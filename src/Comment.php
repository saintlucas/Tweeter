<?php

/* CREATE TABLE Comments(
  id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
  tweetId INT,
  authorId INT,
  message VARCHAR( 60 ) NOT NULL ,
  date TIMESTAMP;
  ); */

require_once 'Tweet.php';

class Comment {

    private $id;
    private $commentedTweetId;
    private $commentAuthorId;
    private $comment;
    private $commentDate;

    public function __construct() {
        $this->id = -1;
        $this->commentedTweetId = '';
        $this->commentAuthorId = '';
        $this->comment = '';
        $this->commentDate = '';
    }

    public function __destruct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setCommentedTweetId($id) {
        $this->commentedTweetId = $id;
    }

    public function getCommentedTweetId() {
        return $this->commentedTweetId;
    }

    public function setCommentAuthorId($commentAuthorId) {
        return $this->commentAuthorId = $commentAuthorId;
    }

    public function getCommentAuthorId() {
        return $this->commentAuthorId;
    }

    public function setComment($comment) {
        if (strlen(trim($comment)) > 0 && strlen(trim($comment)) < 61) {
            $this->comment = $comment;
        }
    }

    public function getComment() {
        return $this->comment;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    static public function addTweetComment(mysqli $connection) {
        if ($this->id == -1) {
            $query = "INSERT INTO Comments(tweetId, authorId, message, date)
                    VALUES ('$this->commentedTweetId', '$this->commentAuthorId', '$this->message', NOW())";

            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

    static public function loadAllTweets(mysqli $connection) {
        $query = "SELECT * FROM Tweets ORDER BY Date DESC LIMIT 0, 10;";

        $tweets = [];

        $result = $connection->query($query);

        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->commentedTweetId = $row['userId'];
                $loadedTweet->tweet = $row['tweet'];
                $loadedTweet->date = $row['date'];

                $tweets[] = $loadedTweet;
            }
        }

        return $tweets;
    }

    static public function loadAllCommentsByTweetId(mysqli $connection, $tweetId) {
        $query = "SELECT * FROM Comments
                 WHERE tweetId = '" . $connection->real_escape_string($tweetId) . "'
            ORDER BY Date DESC
            LIMIT 0,10";

        $comments = [];

        $result = $connection->query($query);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment;
                $loadedComment->id = $row['id'];
                $loadedComment->commentedTweetId = $row['tweetId'];
                $loadedComment->commentAuthorId = $row['userId'];
                $loadedComment->comment = $row['comment'];
                $loadedComment->date = $row['date'];
                $comments[] = $loadedComment;
            }
        }

        return $comments;
    }

}
