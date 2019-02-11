<?php
  // establish connection with db
$db_connection = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db_connection); //

function print_error($msg = "Error: Could not query to database.")
{
  die("<span class='error'>$msg</span>");
  return 1;
}

function getMaxPersonID()
{
  global $db_connection;
  $rs = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
  if (!$rs) {
    if (mysql_error() != "Query was empty")
      return print_error('Query failed: ' . mysql_error());
  } else {
    if ($row = mysql_fetch_row($rs))
      return ($row[0] ? $row[0] : -1);
    return -1;
  }
}

function incrementPersonID($id)
{
  global $db_connection;
  $newID = $id + 1;
  if (!mysql_query("UPDATE MaxPersonID SET id = $newID WHERE id = $id", $db_connection))
    return print_error("Could not update the next available person ID...");
  else
    echo "Successfully added person!";
  return 0;
}

function getMaxMovieID()
{
  global $db_connection;
  $rs = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
  if (!$rs) {
    if (mysql_error() != "Query was empty")
      return print_error('Query failed: ' . mysql_error());
  } else {
    if ($row = mysql_fetch_row($rs))
      return ($row[0] ? $row[0] : -1);
    return -1;
  }
}

function incrementMovieID($id)
{
  global $db_connection;
  $newID = $id + 1;
  if (!mysql_query("UPDATE MaxMovieID SET id = $newID WHERE id = $id", $db_connection))
    print_error("Could not update the next available person ID...");
  else
    echo "Successfully added movie!";
}

function getMovieList()
{
  global $db_connection;
  $movie_list = array();
  if (!($rs = mysql_query("SELECT id, title FROM Movie", $db_connection)))
    print_error("Could not retrieve movie list.");
  else {
    while ($row = mysql_fetch_row($rs)) {
      if ($row[0] && $row[1])
        $movie_list[] = $row;
    }
  }
  return $movie_list;
}

function getActorID($actor)
{ // $actor is "last, first"
  global $db_connection;
  $firstLast = explode(", ", $actor);
  $first = $firstLast[1];
  $last = $firstLast[0];
  $query = "SELECT id FROM Actor WHERE last = '$last' AND first = '$first'";
  if ($rs = mysql_query($query, $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row[0] ? $row[0] : -1;
  }
  return -1;
}

function getDirectorID($director)
{ // $director is "last, first"
  global $db_connection;
  $firstLast = explode(", ", $director);
  $first = $firstLast[1];
  $last = $firstLast[0];
  $query = "SELECT id FROM Director WHERE last = '$last' AND first = '$first'";
  if ($rs = mysql_query($query, $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row[0] ? $row[0] : -1;
  }
  return -1;
}

function getActorToMovieCount($mid, $aid, $role)
{
  global $db_connection;
  if ($rs = mysql_query("SELECT COUNT(*) FROM MovieActor WHERE mid = $mid AND aid = $aid AND role = '$role'", $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row[0];
  }
  return 1;
}

function getDirectorToMovieCount($mid, $did)
{
  global $db_connection;
  if ($rs = mysql_query("SELECT COUNT(*) FROM MovieDirector WHERE mid = $mid AND did = $did", $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row[0];
  }
  return 1;
}

function getActorInfo($id)
{
  global $db_connection;
  if ($rs = mysql_query("SELECT * FROM Actor WHERE id = $id", $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row;
  }
  return array();
}

function getMovieInfo($id)
{
  global $db_connection;
  if ($rs = mysql_query("SELECT * FROM Movie WHERE id = $id", $db_connection)) {
    if ($row = mysql_fetch_row($rs))
      return $row;
  }
  return array();
}

function getActorsListOfMovies($aid)
{
  global $db_connection;
  $list = array();
  $query = "SELECT DISTINCT m.id, title, year FROM Movie m, MovieActor ma WHERE ma.aid = $aid AND ma.mid = m.id ORDER BY m.year DESC";
  if ($rs = mysql_query($query, $db_connection)) {
    while ($row = mysql_fetch_row($rs))
      $list[] = array($row[0], $row[1], $row[2]);
  }
  return $list;
}

function getMoviesListOfActors($mid)
{
  global $db_connection;
  $list = array();
  $query = "SELECT DISTINCT id, last, first, ma.role FROM Actor a, MovieActor ma WHERE ma.mid = $mid AND ma.aid = a.id ORDER BY last";
  if ($rs = mysql_query($query, $db_connection)) {
    while ($row = mysql_fetch_row($rs))
      $list[] = array($row[0], $row[1], $row[2], $row[3]);
  }
  return $list;
}

function getMoviesListOfDirectors($mid)
{
  global $db_connection;
  $list = array();
  $query = "SELECT DISTINCT last, first FROM Director d, MovieDirector md WHERE md.mid = $mid AND md.did = d.id";
  if ($rs = mysql_query($query, $db_connection)) {
    while ($row = mysql_fetch_row($rs))
      $list[] = array($row[0], $row[1]);
  }
  return $list;
}

function getMoviesGenres($mid)
{
  global $db_connection;
  $genres = array();
  if ($rs = mysql_query("SELECT DISTINCT genre FROM MovieGenre mg WHERE mid = $mid", $db_connection)) {
    while ($row = mysql_fetch_row($rs))
      $genres[] = $row[0];
  }
  return $genres;
}

function getReviews($mid)
{
  global $db_connection;
  $reviews = array();
  if ($rs = mysql_query("SELECT DISTINCT * FROM Review WHERE mid = $mid")) {
    while ($row = mysql_fetch_row($rs))
      $reviews[] = $row;
  }
  return $reviews;
}

  // use when stuff was echo'd before a failed header redirect attempt
function issetStr($str)
{
  return isset($str) && $str != "";
}
?>