<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
	"UPDATE bew_etab
	 SET wert=:wert
		,text=:kommentar 
	 WHERE user_id=:user_id 
	   AND etab_id=:etab_id"
);
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userId, 'etab_id' => $etabId));
$pdo = NULL;
