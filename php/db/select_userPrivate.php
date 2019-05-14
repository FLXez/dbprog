<?php
if (isset($userid)) {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort
               FROM user 
               WHERE id = :userid"
       );
       $result = $statement->execute(array('userid' => $userid));
} else {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort
                     ,id as userid
               FROM user 
               WHERE username = :username"
       );
       $result = $statement->execute(array('username' => $username));
}
$userPrivate = $statement->fetch();
