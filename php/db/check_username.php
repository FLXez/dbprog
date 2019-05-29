<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM user 
     WHERE username = :username");
$result = $statement->execute(array('username' => $newUsername));
$username_vorhanden = $statement->fetch();
$pdo = NULL;