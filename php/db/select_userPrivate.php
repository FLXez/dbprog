<?php
$statement = $pdo->prepare(
       "SELECT username as uname
              ,passwort as passwort
        FROM user 
        WHERE id = :userid");
$result = $statement->execute(array('userid' => $userid));
$userPrivate = $statement->fetch();
?>