<!DOCTYPE html>
<?php
include("utils.php");

$str_error = "";

function postReview($name, $mid, $rating, $comment)
{
  global $db_connection, $str_error;
  $comment = isset($_POST["comment"]) ? "'$comment'" : "NULL";
  $query = "INSERT INTO Review (name, mid, rating, comment) VALUES ('$name', $mid, $rating, $comment)";
  // if fail
  if (!mysql_query($query, $db_connection)) {
    $str_error = "Could not post to server.";
    return 1;
  }
  return 0;
}

$movie_list = getMovieList();
$name = $_POST["username"];
$rating = $_POST["rating"];
$comment = $_POST["comment"];
$mid = $movie_list[$_POST["movie"]][0];
// post request sends movie index, so we can get id from movie list
if (issetStr($name) && isset($mid) && issetStr($rating)
  && !postReview($name, $mid, $rating, $comment)) {
  header("Location: success.php");
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
  <script>
    function updateTextInput(val) {
      document.getElementById('rating-label').innerHTML = val;
    }
  </script>
  <body>
    <?php include('nav.html') ?>
    <h1>Add a New Review</h1>
    <form action="addComment.php" method="POST">
      <div>
        Username: <input type="text" name="username" required>
      </div>
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
      <div>
        Rating:
        <input name="rating" type="range" min="1" max="5" value="3" onchange="updateTextInput(this.value);" required>
        <span id='rating-label'>3</span>
      </div>
      <div>
        Additional Comments: <br>
        <textarea name="comment" cols="80" rows="10"></textarea>
      </div>
      <div>
        <input type="submit" value="Submit">
      </div>
    </form>
    <?php print_error($str_error); ?>
  </body>
</html>