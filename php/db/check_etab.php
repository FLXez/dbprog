<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM etab  
     WHERE name = :name 
       AND anschrift =:anschrift
       AND ort =:ort");
$result = $statement->execute(array('name' => $name, 'anschrift' => $strasse, 'ort' => $stadt));
$etab_vorhanden = $statement->fetch();
$pdo = NULL;
