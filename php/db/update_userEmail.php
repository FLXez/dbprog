<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE user 
     SET email = :email 
        ,updated_at = CURRENT_TIMESTAMP 
     WHERE id = :userid");
$result = $statement->execute(array('email' => $_POST['u_ue_emailNew'], 'userid' => $userid));
$pdo = NULL;