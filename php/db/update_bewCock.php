<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE bew_cock 
     SET wert=:wert
        ,text=:kommentar 
     WHERE user_id=:user_id 
       AND cock_etab_id=:cock_etab_id"
);
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userId, 'cock_etab_id' => $cockEtabId));
$pdo = NULL;
if ($result) {
   $_SESSION['message'] = "Erfolgreich bewertet!";
} else {
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
}