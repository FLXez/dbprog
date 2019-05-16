<?php
session_start();
if(isset($_SESSION['userid'])){
       $userid = $_SESSION['userid'];
}
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if (isset($userid)) {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort
               FROM user 
               WHERE id = :userid"
       );
       $result = $statement->execute(array('userid' => $userid));
} else {
       $statement = $pdo->prepare(
              "SELECT passwort as passwort,
                      id as userid,
                      admin as admin
               FROM user 
               WHERE username = :username"
       );
       $result = $statement->execute(array('username' => $username));
}
$userPrivate = $statement->fetch();
$pdo = NULL;