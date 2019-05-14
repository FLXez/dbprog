<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM user 
     WHERE email = :email");
$result = $statement->execute(array('email' => $newEmail));
$userEmail = $statement->fetch();
$pdo = NULL;
