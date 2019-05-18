<?php
if (isset($_SESSION['userId']) && !isset($_SESSION['showUser'])) {
       $userId = $_SESSION['userId'];
} elseif (isset($_SESSION['showUser'])) {
       $userId = $_SESSION['showUser'];
}
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
       "SELECT username as uname
              ,vorname as vname 
              ,nachname as nname
              ,email as email
              ,age as age
              ,beruf as beruf
              ,created_at as ts
              ,img as img
              ,admin as admin
        FROM user 
        WHERE id = :userId"
);
$result = $statement->execute(array('userId' => $userId));
$userInfo = $statement->fetch();
$userInfo["ts"] = date("d.m.Y", strtotime($userInfo['ts']));
$pdo = NULL;
$_SESSION['showUser'] = NULL;