<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id as id
		   ,e.name as name
		   ,e.ort as ort
		   ,ce.preis as preis
		   ,AVG(bc.wert) as wert
	 FROM cock_etab ce
	    JOIN etab e 
            ON e.id = ce.etab_id
		LEFT JOIN bew_cock bc 
            ON ce.cock_id = bc.cock_id 
            AND e.id = bc.etab_id
	 WHERE ce.cock_id = :cock_id
	 GROUP BY e.id
			 ,e.name
			 ,e.ort
			 ,ce.preis
			 ,ce.cock_id");
$result = $statement->execute(array('cock_id' => $cockid));
$cockEtab_bew = $statement->fetchAll();
$pdo = NULL;