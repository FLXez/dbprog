<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM bew_cock
     WHERE id = :id");
$result = $statement->execute(array('id' => $bew_id));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Bewertung erfolgreich gelöscht!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }