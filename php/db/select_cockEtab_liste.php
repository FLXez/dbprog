<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id as eid
		   ,e.name as ename
		   ,e.ort as eort
	 FROM etab e
	 JOIN cock_etab ce 
        ON e.id = ce.etab_id
	 WHERE ce.cock_id = :cock_id");
$result = $statement->execute(array('cock_id' => $cockId));
$cockEtab_liste = $statement->fetchAll();
$pdo = NULL;