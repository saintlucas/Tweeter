<?php

require_once 'src/User1.php';
require_once 'DBConnection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && strlen(trim($_POST['username'])) > 0 && isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5 && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5) {

        $name = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $newUser = new User1();
        $newUser->setUsername($name);
        $newUser->setEmail($email);
        $newUser->setPassword($password);

        if ($newUser->saveToDB($conn)) {

            $user = User1::login($conn, $name, $email, $password);
            //echo 'Rejestracja zakończona powodzeniem';

            if ($user) {
                $_SESSION['user_id'] = $user->getId();
                header('Location: index.php');
                echo 'rejestracja zakończona powodzeniem';
            } else {
                echo 'Niepoprawne dane logowania';
            }
        } else {
            echo 'hasło jest zbyt krótkie lub adres email już istnieje w bazie';
        }
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <form method="POST">
            <label>
                Name:<br>
                <input type="text" name="username">
            </label>
            <br>

            <label>
                Email:<br>
                <input type="text" name="email">
            </label>
            <br>
            <label>
                Password: <br>
                <input type="password" name="password">
            </label>   
            <br>

            <input type="submit" value="Register">
            <br>

            <a href="LoginSite.php">Powrót do strony logowania</a>
        </form>
    </body>
</html>