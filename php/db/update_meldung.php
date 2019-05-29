<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "UPDATE meldung 
        SET status = :status   
     WHERE id= :id"
);
$result = $statement->execute(array('status' => $status, 'id' => $meldId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Meldung wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Aktualisieren der Meldung aufgetreten.";
}