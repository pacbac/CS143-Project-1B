<!DOCTYPE html>
<?php
include("utils.php");

function postPerson($table, $first, $last, $sex, $dob, $dod)
{
  global $db_connection;
  $maxPersonID = getMaxPersonID();
  $query = "INSERT INTO $table VALUES ";
  if ($maxPersonID != -1) {
    $dod = !isset($dod) ? "NULL" : "'$dod'";
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
            <a href="#">Add New Actor to Movie</a>
            <a href="#">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>

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
