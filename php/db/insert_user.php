<?php
$passHash = password_hash($_POST['register_passwort'], PASSWORD_DEFAULT);
$statement = $pdo->prepare(
    "INSERT INTO user (email, passwort, username) 
     VALUES (:email, :passwort, :username)");
$result = $statement->execute(array('email' => $_POST['register_email'], 'passwort' => $passHash, 'username' => $_POST['register_username']));