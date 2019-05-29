<?php
session_start();
if(isset($_SESSION['userId'])){
       $userId = $_SESSION['userId'];
}
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
if (isset($userId)) {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort
               FROM user 
               WHERE id = :userId"
       );
       $result = $statement->execute(array('userId' => $userId));
} else {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort,
                      id as userId,
                      rang as rang
               FROM user 
               WHERE username = :username"
       );
       $result = $statement->execute(array('username' => $username));
}
$userPrivate = $statement->fetch();
$pdo = NULL;