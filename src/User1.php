<?php

class User1 {

    private $id;
    private $username;
    private $email;
    private $hasshedPassword;

    public function __construct() {
        $this->id = -1;
        $this->username = '';
        $this->email = '';
        $this->hasshedPassword = '';
    }

    public function __destruct() {
        
    }

    public function getId() {
        return $this->id;
    }

    function setUsername($username) {
        if (is_string($username) && strlen($username) > 0) {
            $this->username = trim($username);
        }
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setEmail($email) {
        if (is_string($email) && strlen(trim($email)) > 5) {
            $this->email = trim($email);
        }
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($newPassword) {
        if (is_string($newPassword) && strlen(trim($newPassword)) > 5) {
            $newHasshedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $this->hasshedPassword = $newHasshedPassword;
        }

        return $this;
    }

    public function getPassword() {
        return $this->hasshedPassword;
    }

    public function saveToDB(mysqli $connection) {
        if ($this->id === -1) {
            $sql = "INSERT INTO Users (username, email, password)
                    VALUES('$this->username', '$this->email', '$this->hasshedPassword')";
            $result = $connection->query($sql);
            
            if ($result == true) {
                $this->id = $connection->insert_id;
                echo ('Nowy użytkownik' . ' ' . $this->username . ' został dodany do bazy danych.<br>');
                return true;
            } else {
                return false;
            }
        } else { // na wypadek wywołania istniejącego obiektu
            $sql = "UPDATE Users SET username = '$this->username',
                email = '$this->email', password = '$this->hasshedPassword'
                    WHERE user_id = $this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                return true;
            }
        }
        return false;
    }

    static public function loadUserById(mysqli $connection, $id) {

        $query = "SELECT * FROM Users WHERE user_id=$id"; //. $connection->real_escape_string($id);

        $result = $connection->query($query);

        if ($result == true && $result->num_rows == 1) {

            $row = $result->fetch_assoc(); //sprowadź rzędy do postaci tab.asoc.

            $loadedUser = new User1();

            $loadedUser->id = $row['user_id'];
            //$loadedUser->username = $row['username'];
            $loadedUser->setUsername = $row['username'];
            //$loadedUser->email = $row['email'];
            $loadedUser->setEmail = $row['email'];
            //$loadedUser->hasshedPassword = $row['password'];
            $loadedUser->hasshedPassword = $row['password'];

            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers(mysqli $connection) {

        $query = "SELECT * FROM Users";
        
        $users = [];

        $result = $connection->query($query);
        
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User1();
                $loadedUser->id = $row['user_id'];
                $loadedUser->username = $row['username'];
                $loadedUser->email = $row['email'];
                $loadedUser->hasshedPassword = $row['password'];

                $users[] = $loadedUser;
            }
        }
        return $users;
    }

    public function deleteUser(mysqli $connection) {
        if ($this->id != -1) {
            $sql = "DELETE FROM Users WHERE user_id=$this->id";
            $result = $connection->query($sql);
            if ($result == true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

    static public function loadUserByEmail(mysqli $connection, $email) {

        $query = "SELECT * FROM Users WHERE email = '" . $connection->real_escape_string($email) . "'";

        $result = $connection->query($query);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $user = new User1();
            $user->id = $row['user_id'];
            $user->setName = $row['username'];
            $user->setEmail = $row['email'];
            $user->hasshedPassword = $row['password'];

            return $user;
        }

        return null;
    }

    static public function login(mysqli $connection, $email, $password) {

        $user = self::loadUserByEmail($connection, $email);

        if ($user && password_verify($password, $user->hasshedPassword)) {
            return $user;
        } else {
            return false;
        }
    }

    static public function showUserData(mysqli $connection, $userId) {
        $query = "SELECT * FROM Users WHERE id = '" . $connection->real_escape_string($userId) . "'";
        return $query;
    }

    static public function checkAuthorByTweetId(mysqli $connection, $tweetId) {

        $query = "SELECT Users.username, Users.user_id FROM Users
                JOIN Tweets ON Tweets.userId = Users.user_id
                WHERE Tweets.id = '" . $connection->real_escape_string($tweetId) . "'";


        $result = $connection->query($query);

        if ($result == true && $result->num_rows == 1) {
            
            $row = $result->fetch_assoc();
            
            $checkedAuthor = new User1;
            $checkedAuthor->id = $row['user_id'];
            $checkedAuthor->username = $row['username'];
            
            return $checkedAuthor;
        }
        
        return false;
    }
    
    static public function checkAuthorByCommentId(mysqli $connection, $commentId) {
        
        $query = "SELECT Users.username, Users.user_id FROM Users
                JOIN Comments ON Comments.userId = Users.user_id
                WHERE Comments.id = '" . $connection->real_escape_string($commentId) . "'";
        
        $result = $connection->query($query);
        
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            
            $checkedAuthor = new User1;
            $checkedAuthor->id = $row['user_id'];
            $checkedAuthor->name = $row['username'];
            
            return $checkedAuthor;
        }
        
        return false;
    }

}
