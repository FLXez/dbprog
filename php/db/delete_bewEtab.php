<!-- Mit diesem SQL Statement werden Bewertungen von Etablissements gelöscht -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM bew_etab
     WHERE id = :id");
$result = $statement->execute(array('id' => $bew_id));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Bewertung erfolgreich gelöscht!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }