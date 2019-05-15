<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "INSERT 
     INTO etab(name, ort, anschrift, img) 
     VALUES (:name, :ort, :anschrift, :img)");
$result = $statement->execute(array('name' => $name, 'ort' => $stadt, 'anschrift' => $strasse, 'img' => $image));
$pdo = NULL;