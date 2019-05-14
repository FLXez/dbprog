<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
       "SELECT username as uname
              ,vorname as vname 
              ,nachname as nname
              ,email as email
              ,age as age
              ,beruf as beruf
              ,created_at as ts
        FROM user 
        WHERE id = :userid");
$result = $statement->execute(array('userid' => $userid));
$userInfo = $statement->fetch();
$userInfo["ts"] = date("d.m.Y");
$pdo = NULL;
?>