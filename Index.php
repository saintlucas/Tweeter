<?php

require_once 'src/User1.php';
require_once 'src/Tweet.php';
require_once 'DBConnection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: LoginSite.php'); //system logowania - Przekierowanie użytkownika pod dowolny adres
}



