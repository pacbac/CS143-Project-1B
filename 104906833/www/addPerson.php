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
    <link />
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Fira+Sans|Source+Sans+Pro:600,700"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav>
      <div><h1>143MDb</h1></div>

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
            <a href="newMovie.php">Add New Movie</a>
            <a href="newComment.php">Add New Comment</a>
            <a href="#">Add New Actor to Movie</a>
            <a href="#">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>
    <nav>
      <a href="addPerson.php">Add New Actor/Director</a>
      <a href="newMovie.php">Add New Movie</a>
      <a href="newComment.php">Add New Comment</a>
      <a href="#">Add New Actor to Movie</a>
      <a href="#">Add New Director to Movie</a>
      <a href="#">Search</a>
      <a href="#">Get Actor Info</a>
      <a href="#">Get Movie Info</a>
    </nav>
    <h1>Add a New Actor/Director</h1>
    <?php
    $table = $_POST["role"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $dod = $_POST["dod"];
    if (($table == "Actor" || $table == "Director")
      && $firstname != "" && $lastname != ""
      && $dob != "") {
      if ($table == "Actor"
        && !($sex == "Male" || $sex == "Female" || $sex == "Other"))
        print_error("Actor must have a valid gender to be added to site.");
      else
        postPerson($table, $firstname, $lastname, $sex, $dob, $dod);
    }
    ?>
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
        <input type="text" name="dob" required>
        (YYYY-MM-DD)
      </div>
      <div>
        Date of Death:
        <input type="text" name="dod">
        (YYYY-MM-DD)
      </div>
      <input type="submit" value="Submit">
    </form>
    <br/>
    <!-- print out data -->
  </body>
</html>
