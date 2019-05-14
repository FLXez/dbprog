<?php
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM user 
     WHERE email = :email");
$result = $statement->execute(array('email' => $newEmail));
$userEmail = $statement->fetch();
