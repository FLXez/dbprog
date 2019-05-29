<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
       "SELECT username as uname
              ,vorname as vname 
              ,nachname as nname
              ,email as email
              ,age as age
              ,beruf as beruf
              ,created_at as ts
              ,img as img
              ,rang as rang
        FROM user 
        WHERE id = :userId"
);
$result = $statement->execute(array('userId' => $userId));
$userInfo = $statement->fetch();
$userInfo["ts"] = date("d.m.Y", strtotime($userInfo['ts']));
$pdo = NULL;