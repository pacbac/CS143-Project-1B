<!DOCTYPE html>
<?php
$query = $_GET['query']; // get the query from the get request
// establish connection with db
$db_connection = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db_connection); //
?>
<html>
  <body>
    <h1>Enter your SQL query here:</h1>
    <!-- form data, pressing submit will rerun the page with the textarea query -->
    <form action="query.php" method="GET">
      <textarea name="query" cols="60" rows="8"><?php print "$query" ?></textarea>
      <br />
      <input type="submit" value="Submit" />
    </form>
    <br/>
    <!-- print out data -->
    <?php
    // sends query and rs stores array of results
    $rs = mysql_query($query, $db_connection);
    if (!$rs) {
      if (mysql_error() != "Query was empty")
        die('Query failed: ' . mysql_error());
    } else {
      echo "<table border=1 cellspacing=1 cellpadding=2>";
      $i = 0;
      echo "<tr align=center>";
      while ($i < mysql_num_fields($rs)) {
        $meta = mysql_fetch_field($rs, $i);
        echo "<th>$meta->name</th>";
        $i++;
      }
      echo "</tr>";
      while ($row = mysql_fetch_row($rs)) {
        echo "<tr align=center>";
        for ($i = 0; $i < sizeof($row); $i++) {
          $nonnull = ($row[$i] ? $row[$i] : "N/A");
          echo "<td>$nonnull</td>";
        }
        echo "</tr>";
        mysql_close($db_connection);
      }
      echo "</table>";
    }
    ?>
  </body>
</html>
