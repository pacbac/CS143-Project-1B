-- DROP TABLE IF EXISTS Movie;
-- DROP TABLE IF EXISTS Actor;
-- DROP TABLE IF EXISTS Sales;
-- DROP TABLE IF EXISTS Director;
-- DROP TABLE IF EXISTS MovieGenre;
-- DROP TABLE IF EXISTS MovieDirector;
-- DROP TABLE IF EXISTS MovieActor;
-- DROP TABLE IF EXISTS MovieRating;
-- DROP TABLE IF EXISTS Review;
-- DROP TABLE IF EXISTS MaxPersonID;
-- DROP TABLE IF EXISTS MaxMovieID;

CREATE TABLE Movie
(
  -- every movie needs an id & title
  id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  year INT,
  rating VARCHAR(10),
  company VARCHAR(50),
  -- id unique for each movie
  PRIMARY KEY(id),
  -- movie can't be released later than 2019
  CHECK(year <= 2019),
  -- movie id needs to be non-negative
  CHECK(id >= 0)
)
ENGINE=INNODB;

CREATE TABLE Actor
(
  -- every actor needs an id
  id INT NOT NULL,
  last VARCHAR(20),
  first VARCHAR(20),
  sex VARCHAR(6),
  dob DATE NOT NULL,
  dod DATE,
  -- id unique for each actor
  PRIMARY KEY(id),
  -- actor id needs to be non-negative
  CHECK(id>=0)
)
ENGINE=INNODB;

CREATE TABLE Sales
(
  mid INT,
  ticketsSold INT,
  totalIncome INT,
  -- movie id (mid) in Sales needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=INNODB;

CREATE TABLE Director
(
  -- every director needs an id
  id INT NOT NULL,
  last VARCHAR(20),
  first VARCHAR(20),
  -- every director needs a dob
  dob DATE NOT NULL,
  dod DATE,
  -- id unique for each directory
  PRIMARY KEY(id)
)
ENGINE=INNODB;

CREATE TABLE MovieGenre
(
  mid INT,
  genre VARCHAR(20),
  -- movie id (mid) in MovieGenre needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=INNODB;

CREATE TABLE MovieDirector
(
  mid INT,
  did INT,
  -- movie id (mid) in MovieDirector needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  -- director id (did) in MovieDirector needs to be valid id in Director
  FOREIGN KEY (did)
    REFERENCES Director(id)
    ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=INNODB;

CREATE TABLE MovieActor
(
  mid INT,
  aid INT,
  role VARCHAR(50),
  -- movie id (mid) in MovieActor needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  -- actor id (aid) in MovieActor needs to be valid id in Actor
  FOREIGN KEY (aid)
    REFERENCES Actor(id)
    ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=INNODB;

CREATE TABLE MovieRating
(
  mid INT,
  imdb INT,
  rot INT,
  -- movie id (mid) in MovieRating needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  -- imdb rating needs to be between 0 and 100
  CHECK(imdb >= 0 AND imdb <= 100),
  -- rot rating needs to be between 0 and 100
  CHECK(rot >= 0 AND rot <= 100)
)
ENGINE=INNODB;

CREATE TABLE Review
(
  name VARCHAR(20),
  time TIMESTAMP,
  mid INT,
  rating INT,
  comment VARCHAR(500),
  -- movie id (mid) in Review needs to be valid id in Movie
  FOREIGN KEY (mid)
    REFERENCES Movie(id)
    ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=INNODB;

CREATE TABLE MaxPersonID
(
  id INT
)
ENGINE=INNODB;

CREATE TABLE MaxMovieID
(
  id INT
)
ENGINE=INNODB;
