<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM meldung
     WHERE id = :id");
$result = $statement->execute(array('id' => $meldId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Meldung erfolgreich gelöscht!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }