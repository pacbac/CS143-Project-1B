<!DOCTYPE html>
<?php
include("utils.php");

$str_error = "";

$id = $_GET["id"];
$title = "";
$year = "";
$rating = "";
$company = "";
$genres = array();
$actors = array();
if($id && isset($id)){
  $movieInfo = getMovieInfo($id);
  if(sizeof($movieInfo) > 0){
    $title = $movieInfo[1];
    $year = $movieInfo[2];
    $rating = $movieInfo[3];
    $company = $movieInfo[4];
    $actors = getMoviesListOfActors($id);
    $genres = getMoviesGenres($id);
  } else
  $str_error = "Could not retrieve movie. Is the ID correct?";
} else
  $str_error = "Could not retrieve movie. Did you supply a movie ID to look up?";

?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
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
            <a href="getActorInfo.php">Get Actor Info</a>
            <a href="getMovieInfo.php">Get Movie Info</a>
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
            <a href="addDirectorToMovie.php">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>
    <h1><?php echo (!issetStr($str_error) ? "$title ($year)" : "Movie Information Not Found") ?></h1>
    <?php 
      if(issetStr($str_error))
        print_error("<h2>$str_error</h2>");
    ?>
    <form>
      <div>
        <div class="rating">
          <?php echo $rating ?>
        </div>
      </div>
      <div class="genres">
        <?php 
        if(sizeof($genres) > 0){
          foreach($genres as $genre)
            echo "<span class='genre'>$genre</span>";
        } else
          echo "No recorded genres for this movie." 
        ?>
      </div>
      <div>
        Actors:
        <?php
        if(sizeof($actors) > 0){
          echo "<ul>";
          foreach($actors as $actor){
            $id = $actor[0];
            $name = implode(" ", array($actor[2], $actor[1]));
            $role = $actor[3];
            echo "<li><a href='./getActorInfo.php?id=$id'>$name</a> ($role)</li>";
          }
          echo "</ul>";
        } else
          echo "No record of actors for this movie.";
        ?>
      </div>
    </form>
  </body>
</html>