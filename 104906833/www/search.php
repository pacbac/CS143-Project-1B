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
      $query .= " (first LIKE '%$word%' OR last LIKE '%$word')";
    } else {
      $query .= " AND (first LIKE '%$word%' OR last LIKE '%$word')";
    }
  }
  if ($query != "SELECT * FROM Actor WHERE")
    return mysql_query($query, $db_connection);
  else return 0;
}

function make_table($rs)
{
  if ($row = mysql_fetch_row($rs)) {
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
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Fira+Sans|Source+Sans+Pro:600,700"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav>
      <div><a href="./" id="logo">143MDb</a></div>
      <div>
        <div class="dropdown">
          <button class="dropdown-btn">
            Browse
          </button>
          <div class="dropdown-list">
            <a href="#">Get Actor Info</a>
            <a href="#">Get Movie Info</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropdown-btn">
            Search
          </button>
          <div class="dropdown-list">
            <a href="#">Search</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropdown-btn">
            Input
          </button>
          <div class="dropdown-list">
            <a href="addPerson.php">Add New Actor/Director</a>
            <a href="addMovie.php">Add New Movie</a>
            <a href="addComment.php">Add New Comment</a>
            <a href="addActorToMovie.php">Add New Actor to Movie</a>
            <a href="#">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>

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
      if ($movies) {
        $mv_tbl = make_table($movies);
        if ($mv_tbl) $numTables += 1;
      }
      if ($actors) {
        $act_tbl = make_table($actors);
        if ($act_tbl) $numTables += 1;
      }
      if (!$numTables) {
        echo ("<h1>No results found for: $name</h1>");
      }
    }
    mysql_close($db_connection);
    ?>
  </body>
</html>