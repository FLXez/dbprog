<?php
session_start();
if(!isset($_SESSION['userId'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}
 
//Abfrage der Nutzer ID vom Login
$userId = $_SESSION['userId'];
 
echo "Hallo User: ".$userId;
?>