<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT id 
     FROM cock 
     where name = :name");
$result = $statement->execute(array('name' => $cockName));
$select_cock_id = $statement->fetch();
$pdo = NULL;