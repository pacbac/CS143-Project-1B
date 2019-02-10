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
    <title><?php echo (!issetStr($str_error) ? "Actor: $name" : "Actor Information Not Found") ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <h1><?php echo (!issetStr($str_error) ? $name : "Actor Information Not Found") ?></h1>
    <?php 
      if(issetStr($str_error))
        print_error("<h2>$str_error</h2>");
    ?>
    <form>
      <div style="padding-top: 0">
        <h3>Basic Information</h3>
        <div style="padding: 0; margin: 5px; border-left-style: solid">
          <div style="padding: 3px 5px">Sex: <?php echo $sex ?></div>
          <div style="padding: 3px 5px">Date of Birth: <?php echo $dob ?></div>
          <div style="padding: 3px 5px">Date of Death: <?php echo $dod ?></div>
        </div>
      </div>
      <div>
        <h3>Movies</h3>
        <?php
        if(sizeof($movies) > 0){
          echo "<ul>";
          foreach($movies as $movie){
            $id = $movie[0];
            $title = $movie[1];
            $year = $movie[2];
            echo "<li><a href='./getMovieInfo.php?id=$id'>$title</a> | $year</li>";
          }
          echo "</ul>";
        } else
          echo "<div class='error-div'>No record of actor's movies.</div>";
        ?>
      </div>
    </form>
  </body>
</html>