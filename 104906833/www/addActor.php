<!DOCTYPE html>
<?php
  // establish connection with db
  $db_connection = mysql_connect("localhost", "cs143", "");
  mysql_select_db("TEST", $db_connection); //

  function print_error($msg = "Error: Could not query to database."){
    echo $msg;
  }

  function getMaxPersonID(){
    global $db_connection;
    $rs = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
    if (!$rs) {
      if (mysql_error() != "Query was empty")
        die('Query failed: ' . mysql_error());
    } else {
      if($row = mysql_fetch_row($rs))
        return ($row[0] ? $row[0] : -1);
      return -1;
    }
  }

  function incrementPersonID($id){
    global $db_connection;
    $newID = $id + 1;
    if(!mysql_query("UPDATE MaxPersonID SET id = $newID WHERE id = $id", $db_connection))
      print_error("Could not update the next available person ID...");
    else
      echo "Successfully added actor!";
  }

  function postPerson($table, $first, $last, $sex, $dob, $dod){
    global $db_connection;
    $maxPersonID = getMaxPersonID();
    $query = "INSERT INTO $table VALUES ";
    if($maxPersonID != -1){
      $dod = $dod == "" ? "NULL" : "'$dod'"; 
      if($table == "Actor")
        $query .= "($maxPersonID, '$last', '$first', '$sex', '$dob', $dod)";
      else
        $query .= "($maxPersonID, '$last', '$first', '$dob', $dod)";
      if(mysql_query($query, $db_connection)){
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
  </head>
  <body>
    <h1>Add a New Actor/Director</h1>
    <?php 
    $table = $_POST["role"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $dod = $_POST["dod"];
    if(($table == "Actor" || $table == "Director") 
        && $firstname != "" && $lastname != ""
        && $dob != ""){
      if($table == "Actor" 
        && !($sex == "Male" || $sex == "Female" || $sex == "Other"))
        print_error("Actor must have a valid gender to be added to site.");
      else
        postPerson($table, $firstname, $lastname, $sex, $dob, $dod);
    }
    ?>
    <form action="addActor.php" method="POST">
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
