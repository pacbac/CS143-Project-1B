<!DOCTYPE html>
<?php
include("utils.php");

function getAvgRating($id){
  global $db_connection;
  if($rs = mysql_query("SELECT AVG(rating) FROM Review WHERE mid = $id", $db_connection)){
    if($row = mysql_fetch_row($rs))
      return $row[0] ? $row[0] : -1;
  }
  return -1;
}

$str_error = "";

$id = $_GET["id"];
$title = "";
$year = "";
$rating = "";
$company = "";
$genres = array();
$actors = array();
$reviews = array();
$avgRating = 0;
if($id && isset($id)){
  $movieInfo = getMovieInfo($id);
  if(sizeof($movieInfo) > 0){
    $title = $movieInfo[1];
    $year = $movieInfo[2];
    $rating = $movieInfo[3];
    $company = $movieInfo[4];
    $actors = getMoviesListOfActors($id);
    $directors = getMoviesListOfDirectors($id);
    $genres = getMoviesGenres($id);
    $reviews = getReviews($id);
    $avgRating = getAvgRating($id);
    $numReviews = sizeof($reviews);
  } else
  $str_error = "Could not retrieve movie. Is the ID correct?";
} else
  $str_error = "Could not retrieve movie. Did you supply a movie ID to look up?";

?>
<html>
  <head>
    <title><?php echo (!issetStr($str_error) ? "Movie: $title | $year" : "Movie Information Not Found") ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
    <?php include('nav.html') ?>
    <h1><?php echo (!issetStr($str_error) ? "$title | $year" : "Movie Information Not Found") ?></h1>
    <?php 
      if(issetStr($str_error))
        print_error("<h2>$str_error</h2>");
    ?>
    <form action="addComment.php">
      <div style="padding-top: 0">
        <div style="padding: 0; margin-bottom: 10px">
          <h3>Prod. by <?php echo ($company ? $company : "Unknown company") ?></h3>
        </div>
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
        <h3>Directors</h3>
        <?php
        if(sizeof($directors) > 0){
          echo "<ul>";
          foreach($directors as $director){
            $id = $director[0];
            $name = implode(" ", array($director[1], $director[0]));
            echo "<li>$name</li>";
          }
          echo "</ul>";
        } else
          echo (
            "<div class='error-div'>
              No record of directors for this movie.
            </div>"
          );
        ?>
      </div>
      <div class='divider'>
        <h3>Cast</h3>
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
          echo (
            "<div class='error-div'>
              No record of actors for this movie.
            </div>"
          );
        ?>
      </div>
      <div>
        <h3>Reviews</h3>
        <div class="review-summary">
          <h5>Overall Rating:
            <?php
              $person = $numReviews == 1 ? "person" : "people";
              echo $avgRating > 0 ? "$avgRating stars ($numReviews $person)" : "No ratings for this movie.";
            ?>
          </h5>
        </div>
        <?php 
          if(sizeof($reviews) > 0){
            foreach($reviews as $review){
              $name = $review[0];
              $timestamp = explode(" ", $review[1]);
              $date = $timestamp[0];
              $timeWSec = explode(":", $timestamp[1]);
              $time = implode(":", array($timeWSec[0], $timeWSec[1]));
              $rating = $review[3];
              $comment = $review[4];
              echo (
                "<div class='review'>
                  <span>
                    <h3>$name</h3>
                    <p class='time'>$date at $time</p>
                  </span>
                  <p class='divider'>$rating stars</p>
                  <p class='comment'>$comment</p>
                </div>"
              );
            }
          } else
            echo (
              "<div style='padding-left: 0'>
                No reviews for this movie yet. Be the first to add one!
              </div>"
            );
        ?>
        <input type="submit" value="Add review">
      </div>
    </form>
  </body>
</html>