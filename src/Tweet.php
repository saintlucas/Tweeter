<?php

/*
  CREATE TABLE Tweets(
  id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
  userId INT,
  message VARCHAR( 140 ) NOT NULL ,
  date TIMESTAMP;
  );
  )
 */

class Tweet {

    private $id;
    private $userId;
    private $tweet;
    private $date;

    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->tweet = '';
        $this->date = '';
    }

    public function __destruct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setUserId() {
        $this->userId = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setTweet($tweet) {
        if (strlen(trim($tweet)) > 0 && strlen(trim($tweet)) < 141) {
            $this->tweet = $tweet;
        }
    }

    public function getTweet() {
        return $this->tweet;
    }

    public function setDate() {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function saveTweetToDataBase(mysqli $connection) {
        if ($this > id == -1) {
            $query = "INSERT INTO Tweets (userId, tweet, date)
                    VALUES('$this->userId', '$this->tweet', NOW())
                     ";
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    static public function showAllTweets(mysqli $connection) {
        $query = "SELECT * FROM Tweets
                ORDER BY Date DESC
                LIMIT O, 5;
                ";
        $tweets = [];

        $result = $connection->query($query);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = newTweet;
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->date = $row['date'];

                $tweets = [$loadedTweet];
            }
        }
        return $tweets;
    }

    static public function loadTweetById(mysqli $connection, $tweetId) {
        $query = "SELECT * FROM Tweets
                WHERE Tweets.id = '" . $connection->real_escape_string($tweetId) . "'";

        $result = $connection->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row('id');
            $loadedTweet->userId = $row('userId');
            $loadedTweet->tweet = $row('message');
            $loadedTweet->date = $row('date');

            return $loadedTweet;
        }
        return null;
    }

    static public function loadUsersTweets(mysqli $connection, $userId) {
        $query = "SELECT Tweets.id, Tweets.userId, Tweets.message, Tweets.date FROM Tweets
                JOIN Users ON Tweets.userId = Users.user_id
                WHERE Users.user_id = '$userId'";

        $tweets = [];

        $result = $connection->query($query);
        if ($result == true && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweet = $row['message'];
                $loadedTweet->date = $row['date'];

                $tweets[] = $loadedTweet;
            }

            return $tweets;
        }
    }

}
