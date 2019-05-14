<?php
$statement = $pdo->prepare(
    "SELECT email 
     FROM user 
     WHERE email = :email");
$result = $statement->execute(array('email' => $newEmail));
$userEmail = $statement->fetch();
