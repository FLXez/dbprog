<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
	"SELECT '1'
	 FROM bew_cock bc
	 JOIN cock_etab ce ON
		bc.cock_etab_id = ce.id
	 WHERE bc.user_id=:user_id 
	   AND ce.etab_id=:etab_id 
	   AND ce.cock_id=:cock_id");
$result = $statement->execute(array('user_id' => $userId, 'etab_id' => $etabId, 'cock_id' => $cockId));
$bew_vorhanden = $statement->fetch();
$pdo = NULL;