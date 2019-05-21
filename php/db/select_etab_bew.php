<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT u.username as username,
			u.id as userId,
			be.text as text,
			be.wert as wert,
			be.timestamp as ts,
			be.id as bew_id
	 FROM bew_etab be
	    JOIN user u 
            ON be.user_id = u.id
	 WHERE be.etab_id = :etab_id");
$result = $statement->execute(array('etab_id' => $etabId));
$etab_bew = $statement->fetchAll();
for ($i = 0; $i < count($etab_bew); $i++) {
    $etab_bew[$i]["ts"] = date("d.m.Y",strtotime($etab_bew[$i]['ts']));
}
$pdo = NULL;
