<!-- Mit diesem SQL Statement wird eine bestehende Etablissement-Bewertung aktualisiert -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
	"UPDATE bew_etab
	 SET wert=:wert
		,text=:kommentar 
	 WHERE user_id=:user_id 
	   AND etab_id=:etab_id"
);
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userId, 'etab_id' => $etabId));
$pdo = NULL;
if ($result) {
	$_SESSION['message'] = "Erfolgreich bewertet!";
 } else {
	$_SESSION['error'] = true;
	$_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }
