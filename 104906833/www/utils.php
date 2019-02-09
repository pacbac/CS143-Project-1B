<?php
  // establish connection with db
  $db_connection = mysql_connect("localhost", "cs143", "");
  mysql_select_db("TEST", $db_connection); //

  function print_error($msg = "Error: Could not query to database."){
    die("<span class='error'>$msg</span>");
    return 1;
  }

  function getMaxPersonID(){
    global $db_connection;
    $rs = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
    if (!$rs) {
      if (mysql_error() != "Query was empty")
        return print_error('Query failed: ' . mysql_error());
    } else {
      if($row = mysql_fetch_row($rs))
        return ($row[0] ? $row[0] : -1);
      return -1;
    }
  }

  function incrementPersonID($id){
    global $db_connection;
    $newID = $id + 1;
    if(!mysql_query("UPDATE MaxPersonID SET id = $newID WHERE id = $id", $db_connection))
      return print_error("Could not update the next available person ID...");
    else
      echo "Successfully added person!";
    return 0;
  }

  function getMaxMovieID(){
    global $db_connection;
    $rs = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
    if (!$rs) {
      if (mysql_error() != "Query was empty")
        return print_error('Query failed: ' . mysql_error());
    } else {
      if($row = mysql_fetch_row($rs))
        return ($row[0] ? $row[0] : -1);
      return -1;
    }
  }

  function incrementMovieID($id){
    global $db_connection;
    $newID = $id + 1;
    if(!mysql_query("UPDATE MaxMovieID SET id = $newID WHERE id = $id", $db_connection))
      print_error("Could not update the next available person ID...");
    else
      echo "Successfully added movie!";
  }

  function getMovieList(){
    global $db_connection;
    $movie_list = array();
    if(!($rs = mysql_query("SELECT id, title FROM Movie", $db_connection)))
      print_error("Could not retrieve movie list.");
    else {
      while($row = mysql_fetch_row($rs)){
        if($row[0] && $row[1])
          $movie_list[] = $row;
      }
    }
    return $movie_list;
  }

  // use when stuff was echo'd before a failed header redirect attempt
  function issetStr($str){
    return isset($str) && $str != "";
  }
?>