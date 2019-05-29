<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
       "SELECT melder_id
         FROM meldung m
         WHERE id = :id"
);
$result = $statement->execute(array('id' => $meldId));
$meld_muid = $statement->fetch();
$pdo = NULL;