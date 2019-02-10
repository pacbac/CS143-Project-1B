<!DOCTYPE html>
<?php
include("utils.php");

function postPerson($table, $first, $last, $sex, $dob, $dod)
{
  global $db_connection;
  $maxPersonID = getMaxPersonID();
  $query = "INSERT INTO $table VALUES ";
  if ($maxPersonID != -1) {
    $dod = !issetStr($dod) ? "NULL" : "'$dod'";
    if ($table == "Actor")
      $query .= "($maxPersonID, '$last', '$first', '$sex', '$dob', $dod)";
    else
      $query .= "($maxPersonID, '$last', '$first', '$dob', $dod)";
    if (mysql_query($query, $db_connection)) {
      return incrementPersonID($maxPersonID);
    } else
      return print_error("Could not add $table data to the site.");
  } else
    return print_error("Could not retrieve next available actor ID.");
}
?>
<html>
  <head>
    <title>Add New Actor/Director</title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <h1>Add a New Actor/Director</h1>
    <form action="addPerson.php" method="POST">
      <div>
        Type:
        <input type="radio" name="role" value="Actor" required> Actor
        <input type="radio" name="role" value="Director"> Director
      </div>
      <div>First Name: <input type="text" name="firstname" required></div>
      <div>Last Name: <input type="text" name="lastname" required></div>
      <div>
        Sex:
        <input type="radio" name="sex" value="Male"> Male
        <input type="radio" name="sex" value="Female"> Female
        <input type="radio" name="sex" value="Other"> Other
      </div>
      <div>
        Date of Birth:
        <input type="date" name="dob" required>
      </div>
      <div>
        Date of Death:
        <input type="date" name="dod">
      </div>
      <div>
        <input type="submit" value="Submit">
      </div>
    </form>
    <br/>
    <!-- print out data -->
    <?php
    $table = $_POST["role"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $dod = $_POST["dod"];
    if (issetStr($table) && issetStr($firstname) && issetStr($lastname)
      && issetStr($dob)) {
      // extra check exists because directors don't need gender to be stored
      if ($table == "Actor" && !isset($sex))
        return print_error("Actor must have a valid gender to be added to site.");
      else {
        if(!postPerson($table, $firstname, $lastname, $sex, $dob, $dod)) //0 = status ok, 1 = status not ok
          header("Location: success.php");
      }
    }
    ?>
  </body>
</html>
