<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM bew_cock
     WHERE id = :id");
$result = $statement->execute(array('id' => $bew_id));
$pdo = NULL;