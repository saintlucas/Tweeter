<?php

require_once 'src/User1.php';
require_once 'DBConnection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && strlen(trim($_POST['email'])) > 5 && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5) {
        
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $user = User1::login($conn, $email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            header('Location: index.php');
        } else {
            echo 'Niepoprawne dane logowania';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['registration']) && $_GET['registration'] == 'createNewAccount') {
        header('Location: RegisterSite.php');
    }
}

//$conn->close();
//r$conn = null;
?>

<html>
    <head>
        <meta charset="utf-8">
    </head>
    
    <body>
        <form method="POST">
            <label>
                Email: <br>
                <input type="text" name="email">
            </label>
            <br>
            <label>
                Password: <br>
                <input type="password" name="password">
            </label>
            <br>
            <input type="submit" value="Login">
            <br>
        </form>
        <a href="LoginSite.php?registration=createNewAccount"> Zarejestruj się</a>
            
    </body>
    
      

