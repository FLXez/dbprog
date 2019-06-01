<!-- Dieses SQL Statement liefert die Informationen eines Etablissements -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id as id,
			e.name as name,
			e.anschrift as anschrift,
			e.ort as ort,
			e.img as img,
			e.verifiziert as verifiziert
	 FROM etab e
	 WHERE e.id = :etab_id");
$result = $statement->execute(array('etab_id' => $etabId));
$etabInfo = $statement->fetch();
$pdo = NULL;
