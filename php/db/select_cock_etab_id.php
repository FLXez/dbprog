<!-- Dieses SQL Statement gibt die ID der Verknüpfung von Cocktail und Etablissement zurück -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT id as ce_id
     FROM cock_etab
     where cock_id = :cock_id AND etab_id = :etab_id");
$result = $statement->execute(array('cock_id' => $cockId, 'etab_id' => $etabId));
$select_cock_etab_id = $statement->fetch();
$pdo = NULL;