<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: LoginSite.php'); //system logowania - Przekierowanie użytkownika pod dowolny adres
}

require_once 'src/User1.php';
require_once 'src/Tweet.php';
require_once 'DBConnection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tweetToAdd']) && isset($_SESSION['userId'])) {
        
        require_once 'src/Tweet.php';
        require_once 'DBconnection.php';
        
        $tweetToAdd = $_POST['tweetToAdd'];
        $currentUserId = $_SESSION['userId'];
        $tweet = new Tweet();
        $tweet->setUserId($currentUserId);
        $tweet->setTweet($tweetToAdd);
        if ($tweet->saveTheTweetToTheDB($conn)) {
            
        } else {
            echo 'blad';
        }
    }
}



