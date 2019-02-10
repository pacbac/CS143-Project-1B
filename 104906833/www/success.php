<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./css/main.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Fira+Sans|Source+Sans+Pro:600,700"
      rel="stylesheet"
    />
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
    <h1>Success!</h1>
    <h3>Your entry has been added to our website.</h3>
    <a href="./" title="Return to the previous page">Go to home</a>
  </body>
</html>