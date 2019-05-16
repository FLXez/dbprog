<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT u.username as username
		   ,u.id as userid
		   ,bc.text as text
		   ,bc.wert as wert
	       ,bc.timestamp as ts
		   ,e.name as etab_name
		   ,bc.etab_id as etab_id
	 FROM bew_cock bc
	    JOIN user u 
		    ON bc.user_id = u.id
		JOIN etab e 
			ON bc.etab_id = e.id
	 WHERE bc.cock_id = :cock_id
	 ORDER BY e.name");
$result = $statement->execute(array('cock_id' => $cockid));
$cock_bew = $statement->fetchAll();
for ($i = 0; $i < count($cock_bew); $i++) {
    $cock_bew[$i]["ts"] = date("d.m.Y",strtotime($cock_bew[$i]['ts']));
}
$pdo = NULL;