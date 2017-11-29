<?php
session_start();

require_once 'src/User1.php';
require_once 'DBConnection.php';
require_once 'Tweet.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];


        $allTweets = Tweet::showAllTweets($conn, $userId);
        $userNameToGet = User1::loadUserById($conn, $userId);
        $username = $usernameToGet->getUsername();
        $receiverId = $usernameToGet->getId();
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>



        <?php
        echo 'Tweety użytkownika ' . $username . ' :' . ('<br>');

        $allTweets = Tweet::loadAllTweetByUserId($conn, $_SESSION['userId']);
        ?>



        <ul>
            <li><a href="Index.php">Strona główna</a></li>
            <li><a href="UserWebSite.php">Strona użytkownika</a></li>
            <li><a href="ShowPost.php">Wiadomości</a></li>
            <li><a href="LogoutSite.php">Wyloguj się</a></li>
        </ul>

        <h1> Witaj <?php echo User1::loadUserById($conn, $_SESSION['userId'])->getName(); ?></h1>

        <?php
        foreach ($allTweets as $value) {
            echo '<tr>';
            echo "<td>" . $value->getId() . "</td>";
            echo "<td>" . $value->getText() . "</td>";
            echo "<td>" . User::returnUserNameById($conn, $value->getUserId());
            echo '<br><a href="post.php?id=' . $value->getId() . '">Wyświetl post</a>';
            echo '</td>';
            echo "<td>" . $value->getCreationDate() . "</td>";
            echo '</tr>';
        }
        ?>

    </body>
</html>
