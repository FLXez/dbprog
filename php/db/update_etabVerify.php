<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE etab 
     SET verifiziert = :verifiziert 
     WHERE id= :etab_id"
);
$result = $statement->execute(array('verifiziert' => $verify, 'etab_id' => $etabId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich geändert!";
} else {
    $_SESSION['message'] = "Änderung fehlgeschlagen.";
    $_SESSION['error'] = true;
}
