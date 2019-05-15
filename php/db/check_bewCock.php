<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
	"SELECT '1'
	 FROM bew_cock 
	 WHERE user_id=:user_id 
	   AND etab_id=:etab_id 
	   AND cock_id=:cock_id");
$result = $statement->execute(array('user_id' => $userid, 'etab_id' => $bew_etab, 'cock_id' => $cockid));
$bew_vorhanden = $statement->fetch();
$pdo = NULL;