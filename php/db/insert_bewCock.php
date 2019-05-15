<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
			"INSERT 
			 INTO bew_cock (user_id, etab_id, cock_id, wert, text) 
			 VALUES (:user_id, :etab_id, :cock_id, :wert, :kommentar)");
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userid, 'etab_id' => $bew_etab, 'cock_id' => $cockid));
$pdo = NULL;