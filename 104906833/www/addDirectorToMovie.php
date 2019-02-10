<!DOCTYPE html>
<?php
include("utils.php");

$movie_list = getMovieList();
$str_error = "";

function postDirectorToMovie($mid, $director){
  global $db_connection, $str_error;
  $role = $roles[$i];
  $did = getDirectorID($director);
  if($did < 0){
    $str_error = "Could not find director.";
    return 1;
  }
  if(!getDirectorToMovieCount($mid, $did)){
    // if fail
    if(!mysql_query("INSERT INTO MovieDirector VALUES ($mid, $did)", $db_connection)){
      $str_error = "Could not post $director to server.";
      return 1;
    }
    return 0;
  }
  $str_error = "$director already exists in movie.";
  return 1;
}

$mid = $movie_list[$_POST["movie"]][0];
$director = $_POST["director"];
if(isset($mid) && isset($director)
  && !postDirectorToMovie($mid, $director))
  header("Location: success.php");
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <h1>Add Director to Movie</h1>
    <form action="addDirectorToMovie.php" method="POST">
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
      <div id="new-director-list">
        <h3>Director</h3>
        <div>
        <span>Name:</span><input type="text" name="director" required> (Last, First)
        </div>
      </div>
      <div>
        <input type="submit" value="Submit">
      </div>
    </form>
    <?php print_error($str_error); ?>
  </body>
</html>