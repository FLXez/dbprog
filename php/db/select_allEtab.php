<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT id
		   ,name
		   ,ort
     FROM etab");
$result = $statement->execute();
$allEtab = $statement->fetchAll();
$pdo = NULL;
