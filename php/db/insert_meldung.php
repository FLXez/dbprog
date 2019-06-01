<!-- Mit diesem SQL Statement werden Meldungen in die Datenbank geschrieben -->
<?php

$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "INSERT INTO meldung 
            (cock_id, etab_id, melder_id, meldung_art, status, user_id)
         VALUES
            (:cock_id, :etab_id, :melder_id, :meldung_art, :status, :user_id);"
);
$result = $statement->execute(array('cock_id' => $cockId, 'etab_id' => $etabId, 'melder_id' => $melderId, 'meldung_art' => $meldungArt, 'status' => 0, 'user_id' => $userId,));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Meldung abgegeben.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
}
 