<!DOCTYPE html>
<?php
include("utils.php");

function search_movie($input)
{
  global $db_connection;
  $query = "SELECT * FROM Movie WHERE";

  $searchWords = explode(" ", $input);
  foreach ($searchWords as $i => $word) {
    if ($i == 0) {
      $query .= " title LIKE '%$word%'";
    } else {
      $query .= " AND title LIKE '%$word%'";
    }
  }
  if ($query != "SELECT * FROM Movie WHERE") {
    return mysql_query($query, $db_connection);
  } else return 0;
}

function search_actor($input)
{
  global $db_connection;
  $query = "SELECT * FROM Actor WHERE";

  $searchWords = explode(" ", $input);
  $i = 0;
  foreach ($searchWords as $i => $word) {
    if ($i == 0) {
      $query .= " (first LIKE '%$word%' OR last LIKE '%$word%')";
    } else {
      $query .= " AND (first LIKE '%$word%' OR last LIKE '%$word%')";
    }
  }
  if ($query != "SELECT * FROM Actor WHERE")
    return mysql_query($query, $db_connection);
  else return 0;
}

function make_table($rs, $type)
{
  if ($row = mysql_fetch_row($rs)) {
    if ($type == "movie") {
      echo "<h2>Movies</h2>";
    } else if ($type == "actor") {
      echo "<h2>Actors</h2>";
    }
    echo "<table border=1 cellspacing=1 cellpadding=2>";
    $i = 0;
    echo "<tr align=center>";
    while ($i < mysql_num_fields($rs)) {
      $meta = mysql_fetch_field($rs, $i);
      echo "<th>$meta->name</th>";
      $i++;
    }
    echo "</tr>";
    do {
      echo "<tr align=center>";
      for ($i = 0; $i < sizeof($row); $i++) {
        $nonnull = ($row[$i] ? $row[$i] : "N/A");
        echo "<td>$nonnull</td>";
      }
      echo "</tr>";
    } while ($row = mysql_fetch_row($rs));
    echo "</table>";
    return 1;
  } else {
    return 0;
  }
}
?>
<html>
  <head>
    <title>143MDb Search</title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="./css/search.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <h1>Search for an actor or movie</h1>
    <form action="search.php" method="GET">
      <div>Name: <input type="text" name="name" required></div>
      <div>
        <input type="submit" value="Submit" />
      </div>
    </form>
    <br/>
    <!-- print out data -->
    <?php
    $name = $_GET["name"];
    if (issetStr($name)) {
      $movies = search_movie($name);
      $actors = search_actor($name);
      $numTables = 0;
      echo "<h2 id=\"results\">Showing results for \"$name\"</h2>";
      if ($movies) {
        $mv_tbl = make_table($movies, "movie");
        if ($mv_tbl) $numTables += 1;
      }
      if ($actors) {
        $act_tbl = make_table($actors, "actor");
        if ($act_tbl) $numTables += 1;
      }
      if (!$numTables) {
        echo "
          <script>
            let e = document.getElementById('results');
            e.innerHTML = '<h2>No results found for \"$name\"</h2>';
          </script>
        ";
      }
    }
    mysql_close($db_connection);
    ?>
  </body>
</html>
