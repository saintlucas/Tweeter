<?php

$servername = 'localhost';
$username = 'root';
$password = 'coderslab';
$baseName = 'Twitter';

$conn = new mysqli ($servername, $username, $password, $baseName);

if($conn->connect_error){
    die("Połączenie nieduadne. Błąd:" .$conn->connect_error);
}
echo("Połączenie udane." .'<br>');

$conn->set_charset("utf8");

//$conn->close;
//$conn->null;

//W PHP komunikacja z MySQL polega na wysyłaniu
 //zapytań (queries) przez obiekt klasy mysqli.

//$result = $conn->query("Tekst zapytania SQL - czyli to, co jest w zmiennej sql");
//$result = $conn->query($sql);