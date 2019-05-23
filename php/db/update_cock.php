<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE cock 
     SET name = :name,
         beschreibung = :beschreibung,
         img = :img
     WHERE id= :cock_id"
);
$result = $statement->execute(array('name' => $name, 'beschreibung' => $beschreibung, 'cock_id' => $cockId, 'img' => $img));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich geändert!";
} else {
    $_SESSION['message'] = "Änderung fehlgeschlagen.";
    $_SESSION['error'] = true;
}
