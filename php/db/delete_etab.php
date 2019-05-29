<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM etab
     WHERE id = :id");
$result = $statement->execute(array('id' => $etabId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Etablissement erfolgreich gelöscht!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }