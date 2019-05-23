<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "INSERT 
     INTO etab(name, ort, anschrift, img) 
     VALUES (:name, :ort, :anschrift, :img)"
);
$result = $statement->execute(array('name' => $name, 'ort' => $ort, 'anschrift' => $anschrift, 'img' => $image));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich hinzugefügt!";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
}
