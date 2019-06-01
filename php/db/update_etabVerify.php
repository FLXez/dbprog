<!-- Mit diesem SQL Statement wird ein Etablissement verifiziert oder unverifiziert -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
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
