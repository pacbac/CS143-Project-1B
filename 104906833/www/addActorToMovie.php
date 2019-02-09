<!DOCTYPE html>
<?php
include("utils.php");

$movie_list = getMovieList();
$str_error = "";

function postActorToMovie($mid, $actors, $roles){
  global $db_connection, $str_error;
  foreach($actors as $i => $actor){
    $role = $roles[$i];
    $aid = getActorID($actor);
    if($aid < 0){
      $str_error = "Could not find actor.";
      return 1;
    }
    $query = "INSERT INTO MovieActor VALUES ($mid, $aid, '$role')";
    // if fail
    if(!mysql_query($query, $db_connection)){
      $str_error = "Could not post $actor to server.";
      return 1;
    }
  }
  return 0;
}

$mid = $movie_list[$_POST["movie"]][0];
$actors = $_POST["actor"];
$roles = $_POST["role"];
if(isset($mid) && sizeof($actors) > 0 && sizeof($roles) > 0
  && !postActorToMovie($mid, $actors, $roles))
  header("Location: success.php");
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <script>
    function addActors(){
      document.getElementById("new-actor-list").innerHTML += 
        'Actor: <br>Name: <input type="text" name="actor[]" required> (Last, First) <br>Role: <input type="text" name="role[]" required><br>';
    }
  </script>
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
    <h1>Add Actor to Movie</h1>
    <form action="addActorToMovie.php" method="POST">
      <div>
        Movie:
        <select name="movie" required>
          <?php
          foreach($movie_list as $i => $movie){
            $id = $movie[0];
            $title = $movie[1];
            print "<option value='$i'>$title</option>";
          }
          ?>
        </select>
      </div>
      <div id="new-actor-list">
        Actor: <br>
        Name: <input type="text" name="actor[]" required> (Last, First) <br>
        Role: <input type="text" name="role[]" required> <br>
      </div>
      <div>
        <button type="button" onclick="addActors()">Add Actors</button>
      </div>
      <div>
        <input type="submit" value="Submit">
      </div>
    </form>
    <?php print_error($str_error); ?>
  </body>
</html>