<?php
session_start();
if ($_SESSION['admin'] >= 1) {
    if ($_SESSION['verify'] == 0) {
        $verify = 1;
    } else {
        $verify = 0;
    }
    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
    $statement = $pdo->prepare(
        "UPDATE etab 
     SET verifiziert = :verifiziert 
     WHERE id= :etab_id"
    );
    $result = $statement->execute(array('verifiziert' => $verify, 'etab_id' => $_SESSION['etabid']));
    $pdo = NULL;
    if ($result) {
        $_SESSION['message'] = "Erfolgreich geändert!";
    } else {
        $_SESSION['message'] = "Verifizierung fehlgeschlagen.";
        $_SESSION['error'] = true;
    }
    $_SESSION['verify'] = NULL;
    $_SESSION['etabid'] = NULL;
}
header("Location: ../" . $_SESSION['source']);