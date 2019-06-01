<!-- Mit diesem SQL Statement werden Bewertungen zu Etablissements in die Datenbank geschrieben -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "INSERT 
     INTO bew_etab (user_id, etab_id, wert, text) 
     VALUES (:user_id, :etab_id, :wert, :kommentar)");
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userId, 'etab_id' =>  $etabId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich bewertet!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }