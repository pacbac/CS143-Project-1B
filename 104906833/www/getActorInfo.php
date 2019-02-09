<!DOCTYPE html>
<?php
include("utils.php");

$str_error = "";

$id = $_GET["id"];
$name = "";
$sex = "";
$dob = "";
$dod = "";
$movies = array();
if($id && isset($id)){
  $actorInfo = getActorInfo($id);
  if(sizeof($actorInfo) > 0){
    $name = implode(" ", array($actorInfo[2], $actorInfo[1]));
    $sex = $actorInfo[3];
    $dob = $actorInfo[4];
    $dod = isset($actorInfo[5]) ? $actorInfo[5] : "N/A";
    $movies = getActorsListOfMovies($id);
  } else
  $str_error = "Could not retrieve actor. Is the ID correct?";
} else
  $str_error = "Could not retrieve actor. Did you supply an actor ID to look up?";

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
            <a href="addDirectorToMovie.php">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>
    <h1>Actor Information</h1>
    <?php 
      if(issetStr($str_error))
        print_error("<h2>$str_error</h2>");
    ?>
    <form>
      <div>
        Name: <?php echo $name ?> <br>
      </div>
      <div>
        Sex: <?php echo $sex ?> <br>
      </div>
      <div>
        Date of Birth: <?php echo $dob ?> <br>
      </div>
      <div>
        Date of Death: <?php echo $dod ?> <br>
      </div>
      <div>
        Movies played in:
        <?php
        if(sizeof($movies) > 0){
          echo "<br>";
          foreach($movies as $i => $movie){
            $title = $movie[0];
            $year = $movie[1];
            $num = $i + 1;
            echo "$num. $title ($year)<br>";
          }
        } else
          echo "No record of actor's movies.";
        ?>
      </div>
    </form>
  </body>
</html>