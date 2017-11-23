<?php

class Message {

    private $id;
    private $commentatorId;
    private $commentedId;
    private $message;
    private $status;

    public function __construct() {

        $this->id = -1;
        $this->commentatorId = '';
        $this->commentedId = '';
        $this->message = '';
        $this->status = '';
    }

    public function __destruct() {
    }

    public function getId() {
        return $this->id;
    }

    function getCommentatorId() {
        return $this->commentatorId;
    }

    function getCommentedId() {
        return $this->commentedId;
    }

    function getMessage() {
        return $this->message;
    }

    function setMessage() {
        $this->message = $message;
    }

    function setCommentedId() {
        $this->commentedId = $commentedId;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus() {
        $this->status = $status;
    }

    public function addMessageToDB(mysqli $connection) {

        if ($this->id == -1) {
            $query = "INSERT INTO Messages (commentatorId, commentedId, message, status, date)
                    VALUES( '$this->commentatorId', '$this->commentedIdId', '$this->message', $this->status, NOW()
                    )";
            if ($connection->query($query)) {
                $this->id = $connection->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }
    
    static public function loadSentMessagesByUserId(mysqli $connection, $userId) {

        $query = "SELECT Messages.id, message, status, date, Users.name AS sender, User2.name AS receiver
                 FROM Messages
                 JOIN Users ON Users.id = Messages.senderId
                 JOIN Users AS User2 ON User2.id = Messages.receiverId
                 WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                 ORDER BY date DESC";
        
        $result = $connection->query($query);
        
        return $result;
 
    }
    
    
    static public function loadReceivedMessagesByUserId(mysqli $connection, $userId) {
        
        $query = "SELECT Messages.id, message, status, date, Users.name AS receiver, User2.name AS sender
                 FROM Messages
                 JOIN Users ON Users.id = Messages.receiverId
                 JOIN Users AS User2 ON User2.id = Messages.senderId
                 WHERE Users.id = '" . $connection->real_escape_string($userId) . "'
                 ORDER BY date DESC";
        
        $result = $connection->query($query);
        
        return $result;
    }
    
    
    
    static public function changeMessageStatus(mysqli $connection, $messageId) {
        
        $query = "UPDATE Messages SET `date` = `date`, status = 1 WHERE id = '$messageId'";
        
        if ($connection->query($query)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    static public function loadMessageById(mysqli $connection, $messageId) {
        
        $query = "SELECT message FROM Messages WHERE id = '$messageId'";
        
        $result = $connection->query($query);
        
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->message = $row['message'];
            
            return $loadedMessage;
        }
        return null;
    }

}

/*CREATE TABLE Messages(
id INT( 6 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
commentatorId INT,
commentedId INT,
message VARCHAR( 500 ) NOT NULL,
status INT,
date TIMESTAMP;
);  