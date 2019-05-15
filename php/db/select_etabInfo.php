<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id as id,
			e.name as name,
			e.anschrift as anschrift,
			e.ort as ort,
			e.img as img,
			e.verifiziert as verifiziert
	 FROM etab e
	 WHERE e.id = :etab_id");
$result = $statement->execute(array('etab_id' => $etabid));
$etabInfo = $statement->fetch();
$pdo = NULL;
