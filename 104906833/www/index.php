<!DOCTYPE html>
<?php
include("utils.php");

function postPerson($table, $first, $last, $sex, $dob, $dod)
{
  global $db_connection;
  $maxPersonID = getMaxPersonID();
  $query = "INSERT INTO $table VALUES ";
  if ($maxPersonID != -1) {
    $dod = $dod == "" ? "NULL" : "'$dod'";
    if ($table == "Actor")
      $query .= "($maxPersonID, '$last', '$first', '$sex', '$dob', $dod)";
    else
      $query .= "($maxPersonID, '$last', '$first', '$dob', $dod)";
    if (mysql_query($query, $db_connection)) {
      incrementPersonID($maxPersonID);
    } else
      print_error("Could not add actor data to the site.");
  } else
    print_error("Could not retrieve next available actor ID.");
}
?>
<html>
  <head>
    <title>143MDb Home</title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <div style="margin-top: 15px;">
      <img src="./imgs/imdb.png" alt="" style="width: 100%;">
    </div>
  </body>
</html>
