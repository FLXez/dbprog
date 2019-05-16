<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT u.username as username,
			u.id as userid,
			be.text as text,
			be.wert as wert,
			be.timestamp as ts
	 FROM bew_etab be
	    JOIN user u 
            ON be.user_id = u.id
	 WHERE be.etab_id = :etab_id");
$result = $statement->execute(array('etab_id' => $etabid));
$etab_bew = $statement->fetchAll();
for ($i = 0; $i < count($etab_bew); $i++) {
    $etab_bew[$i]["ts"] = date("d.m.Y",strtotime($etab_bew[$i]['ts']));
}
$pdo = NULL;
