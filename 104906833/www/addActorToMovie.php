<!DOCTYPE html>
<?php
include("utils.php");

$movie_list = getMovieList();
$str_error = "";
$str_success = "";

function postActorToMovie($mid, $actors, $roles)
{
  global $db_connection, $str_error, $str_success;
  foreach ($actors as $i => $actor) {
    $role = $roles[$i];
    $aid = getActorID($actor);
    if ($aid < 0)
      $str_error .= "Could not find actor.<br>";
    if (!getActorToMovieCount($mid, $aid, $role)) {
      // if fail
      if (!mysql_query("INSERT INTO MovieActor VALUES ($mid, $aid, '$role')", $db_connection))
        $str_error .= "Could not post $actor to server.<br>";
      else
        $str_success .= "Successfully posted $actor to server as $role.<br>";
    } else
      $str_error .= "$actor already exists in movie as $role.";
  }
  return issetStr($str_error) ? 1 : 0;
}

$mid = $movie_list[$_POST["movie"]][0];
$actors = $_POST["actor"];
$roles = $_POST["role"];
if (isset($mid) && sizeof($actors) > 0 && sizeof($roles) > 0
  && !postActorToMovie($mid, $actors, $roles) && !issetStr($str_error))
  header("Location: success.php");
?>
<html>
  <head>
    <title>Add Actor To Movie</title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <script>
    function addActors(){
      document.getElementById("new-actor-list").innerHTML +=
        '<div>Actor: <br>Name: <input type="text" name="actor[]" required> (Last, First) <br>Role: <input type="text" name="role[]" required><br></div>';
    }
  </script>
  <body>
    <?php include('nav.html') ?>
    <h1>Add Actor to Movie</h1>
    <form action="addActorToMovie.php" method="POST">
      <div>
        Movie:
        <select name="movie" required>
          <?php
          foreach ($movie_list as $i => $movie) {
            $id = $movie[0];
            $title = $movie[1];
            print "<option value='$i'>$title</option>";
          }
          ?>
        </select>
      </div>
      <div id="new-actor-list">
        <h3>Actor</h3>
        <div>
          <span>Name:</span><input type="text" name="actor[]" required> (Last, First)
        </div>
        <div>
          <span>Role:</span><input type="text" name="role[]" required>
        </div>
      </div>
      <div>
        <button id="add-actor-btn" type="button" onclick="addActors()">Add Another</button>
      </div>
      <div>
        <input type="submit" value="Submit">
      </div>
    </form>
    <?php
    echo "<span class='success'>$str_success</span><br>";
    print_error($str_error);
    ?>
  </body>
</html>