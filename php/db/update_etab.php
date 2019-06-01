<!-- Mit diesem SQL Statement wird ein bestehendes Etablissement bearbeitet -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "UPDATE etab 
     SET name = :name,
         ort = :ort,
         anschrift = :anschrift,
         img = :img
     WHERE id= :etab_id"
);
$result = $statement->execute(array('name' => $name, 'ort' => $ort, 'anschrift' => $anschrift, 'etab_id' => $etabId, 'img' => $img));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich geändert!";
} else {
    $_SESSION['message'] = "Änderung fehlgeschlagen.";
    $_SESSION['error'] = true;
}
