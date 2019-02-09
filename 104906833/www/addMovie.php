<!DOCTYPE html>
<?php 
include("utils.php");

function postMovie($title, $year, $rating, $company, $genres){
  global $db_connection;
  $maxMovieID = getMaxMovieID();
  $query = "INSERT INTO Movie VALUES ($maxMovieID, '$title', $year, '$rating', '$company')";
  if (mysql_query($query, $db_connection)) {
    // insert all genres of the movie into db
    foreach($genres as $genre){
      $genreQuery = "INSERT INTO MovieGenre VALUES ($maxMovieID, '$genre')";
      if(!mysql_query($genreQuery, $db_connection))
        return print_error("Could not add genre $genre to movie.");
    }
    return incrementMovieID($maxMovieID);
  } else
    return print_error("Could not add movie data to the site.");
}
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
  </head>
  <body>
  <nav>
      <div><a href=index.php id="logo">143MDb</a></div>

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
            <a href="#">Add New Actor to Movie</a>
            <a href="#">Add New Director to Movie</a>
          </div>
        </div>
      </div>
    </nav>
    <h1>Add New Movie Info</h1>
    <form action="addMovie.php" method="POST">
      <div>
        Title: <input type="text" name="title" required> 
      </div>
      <div>
        Year:
        <input type="number" name="year" min="0" required>
        (YYYY)
      </div>
      <div>
        MPAA Rating:
        <select name="rating" required>
          <option value="G" selected>G</option>
          <option value="PG">PG</option>
          <option value="PG-13">PG-13</option>
          <option value="R">R</option>
          <option value="NC-17">NC-17</option>
        </select>
      </div>
      <div>
        Company: <input type="text" name="company">
      </div>
      <div>
        Genre: <br>
        <input type="checkbox" name="genre[]" value="Action"> Action
        <input type="checkbox" name="genre[]" value="Adult"> Adult <br>
        <input type="checkbox" name="genre[]" value="Adventure"> Adventure
        <input type="checkbox" name="genre[]" value="Animation"> Animation <br>
        <input type="checkbox" name="genre[]" value="Comedy"> Comedy
        <input type="checkbox" name="genre[]" value="Crime"> Crime <br>
        <input type="checkbox" name="genre[]" value="Documentary"> Documentary
        <input type="checkbox" name="genre[]" value="Drama"> Drama <br>
        <input type="checkbox" name="genre[]" value="Family"> Family
        <input type="checkbox" name="genre[]" value="Fantasy"> Fantasy <br>
        <input type="checkbox" name="genre[]" value="Horror"> Horror
        <input type="checkbox" name="genre[]" value="Musical"> Musical <br>
        <input type="checkbox" name="genre[]" value="Mystery"> Mystery
        <input type="checkbox" name="genre[]" value="Romance"> Romance <br>
        <input type="checkbox" name="genre[]" value="Sci-Fi"> Sci-Fi
        <input type="checkbox" name="genre[]" value="Short"> Short <br>
        <input type="checkbox" name="genre[]" value="Thriller"> Thriller
        <input type="checkbox" name="genre[]" value="War"> War <br>
        <input type="checkbox" name="genre[]" value="Western"> Western
      </div>
      <!-- <div>
        Add one actor here to start with: <br/>
        Actor name: <input type="text" name="actorname" required>
        Role name: <input type="text" name="rolename" required>
      </div> -->
      <input type="submit" value="Submit">
    </form>
  </body>
  <?php 
  $title = $_POST["title"];
  $year = $_POST["year"];
  $rating = $_POST["rating"];
  $company = $_POST["company"];
  $genres = $_POST["genre"];
  // if all required params are valid and posting was valid
  if(issetStr($title) && isset($year) && issetStr($rating) && issetStr($company)
    && !postMovie($title, $year, $rating, $company, $genres))
    header("Location: success.php");
  ?>
</html>