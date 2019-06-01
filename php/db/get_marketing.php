<!-- Mit diesem SQL Statement werden die Daten für die Marketing-Karten auf der Hauptseite geladen -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
	"SELECT DISTINCT
		e.id as id
	   ,e.name as name
	   ,e.img as img
	 FROM etab e
	 JOIN bew_etab be
		ON e.id = be.etab_id
	 WHERE e.verifiziert = 1 
	   AND be.wert in ('3','4','5') 
	   AND e.img IS NOT NULL"
);
$result = $statement->execute();
$etabFetch = $statement->fetchAll();
$etabFetch_count = count($etabFetch);

if ($etabFetch_count > 3) {

	$etab1 = $etabFetch[rand(1, $etabFetch_count) - 1];
	$etab2 = $etab1;
	$etab3 = $etab1;

	while ($etab2[0] == $etab1[0]) {
		$etab2 = $etabFetch[rand(1, $etabFetch_count) - 1];
	}

	while ($etab3[0] == $etab1[0] || $etab3[0] == $etab2[0]) {
		$etab3 = $etabFetch[rand(1, $etabFetch_count) - 1];
	}
} else {
	$statement = $pdo->prepare(
		"SELECT DISTINCT
			e.id as id
	       ,e.name as name
		   ,e.img as img
		 FROM etab e
		 JOIN bew_etab be 
	   		ON e.id = be.etab_id"
	);
	$result = $statement->execute();
	$etabFetch = $statement->fetchAll();
	$etabFetch_count = count($etabFetch);

	$etab1 = $etabFetch[rand(1, $etabFetch_count) - 1];
	$etab2 = $etab1;
	$etab3 = $etab1;

	while ($etab2[0] == $etab1[0]) {
		$etab2 = $etabFetch[rand(1, $etabFetch_count) - 1];
	}

	while ($etab3[0] == $etab1[0] || $etab3[0] == $etab2[0]) {
		$etab3 = $etabFetch[rand(1, $etabFetch_count) - 1];
	}
}
$statement = $pdo->prepare(
	"SELECT
		be.text as text
	   ,u.username as name
       ,u.id as id
	 FROM bew_etab be
	 JOIN user u 
	 	ON be.user_id = u.id
	 WHERE be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab1[0]));
$bew1Fetch = $statement->fetchAll();
$bew1Fetch_count = count($bew1Fetch);

$bew1 = $bew1Fetch[rand(1, $bew1Fetch_count) - 1];

$statement = $pdo->prepare(
	"SELECT
		be.text as text
	   ,u.username as name
       ,u.id as id
	 FROM bew_etab be
	 JOIN user u 
	 	ON be.user_id = u.id
	 WHERE be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab2[0]));
$bew2Fetch = $statement->fetchAll();
$bew2Fetch_count = count($bew2Fetch);

$bew2 = $bew2Fetch[rand(1, $bew2Fetch_count) - 1];

$statement = $pdo->prepare(
	"SELECT
		be.text as text
	   ,u.username as name
       ,u.id as id
	 FROM bew_etab be
	 JOIN user u 
	 	ON be.user_id = u.id
	 WHERE be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab3[0]));
$bew3Fetch = $statement->fetchAll();
$bew3Fetch_count = count($bew3Fetch);

$bew3 = $bew3Fetch[rand(1, $bew3Fetch_count) - 1];

$pdo = NULL;
