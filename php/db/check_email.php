<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM user 
     WHERE email = :email");
$result = $statement->execute(array('email' => $newEmail));
$email_vorhanden = $statement->fetch();
$pdo = NULL;
