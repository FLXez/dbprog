<?php
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM user 
     WHERE username = :username");
$result = $statement->execute(array('username' => $newUsername));
$userUsername = $statement->fetch();