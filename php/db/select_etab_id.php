<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT id as id
     FROM etab 
     where name = :name");
$result = $statement->execute(array('name' => $etabName));
$select_etab_id = $statement->fetch();
$pdo = NULL;