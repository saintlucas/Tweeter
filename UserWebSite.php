<?php

require_once 'src/User1.php';
require_once 'DBConnection.php';
require_once 'Tweet.php';

session_start();

if (!isset($_SESSION['user_id'])){
    header('Location: loginSite.pžhp');
}

