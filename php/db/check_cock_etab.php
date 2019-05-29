<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM cock_etab
     WHERE cock_id=:cock_id 
     AND etab_id=:etab_id "
);
$result = $statement->execute(array('cock_id' => $cockId, 'etab_id' => $etabId));
$cock_etab_vorhanden = $statement->fetch();
$pdo = NULL;
