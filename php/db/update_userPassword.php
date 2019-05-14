<?php
$passHash = password_hash($_POST['u_up_passNew'], PASSWORD_DEFAULT);
$statement = $pdo->prepare(
    "UPDATE user 
     SET passwort = :passwort
        ,updated_at = CURRENT_TIMESTAMP 
     WHERE id = :userid");
$result = $statement->execute(array('passwort' => $passHash, 'userid' => $userid));