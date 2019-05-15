<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if(isset($cockid)){
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
} else {
	$statement = $pdo->prepare(
		"SELECT c.id as id,
				c.name as name,
				ce.preis as preis
		 FROM cock_etab ce
		 	JOIN cock c 
			 	ON c.id = ce.cock_id
		 WHERE ce.etab_id = :etab_id");
$result = $statement->execute(array('etab_id' => $etabid));
}
$cocktailkarte = $statement->fetchAll();
$pdo = NULL;