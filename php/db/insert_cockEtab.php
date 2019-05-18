<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
	"INSERT 
	 INTO cock_etab(etab_id, cock_id, preis) 
	 VALUES(:etab_id, :cock_id, :preis)");					
$result = $statement->execute(array('etab_id' => $etabId, 'cock_id' => $cockId, 'preis' => $preis));
$pdo = NULL;