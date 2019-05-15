<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM cock 
     WHERE name = :name 
       AND beschreibung = :beschreibung");
$result = $statement->execute(array('name' => $cockName, 'beschreibung' => $cockDesc));
$cock_vorhanden = $statement->fetch();
$pdo = NULL;
