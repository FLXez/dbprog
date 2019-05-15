<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id as id
		   ,e.name as name
		   ,e.ort as ort
	 FROM etab e
	 JOIN cock_etab ce 
        ON e.id = ce.etab_id
	 WHERE ce.cock_id = :cock_id");
$result = $statement->execute(array('cock_id' => $cockid));
$cockEtab_liste = $statement->fetchAll();
$pdo = NULL;