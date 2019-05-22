<?php

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "INSERT INTO log 
        (mod_id, aktion, etab_id, cock_id)
     VALUES
        (:mod_id, :aktion, :etab_id, :cock_id);"
);
$result = $statement->execute(array('mod_id' => $modId, 'aktion' => $aktion, 'etab_id' => $etabId, 'cock_id' => $cockId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Meldung abgegeben.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
}
