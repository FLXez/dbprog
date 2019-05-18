<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT id 
     FROM cock_etab
     where cock_id = :cock_id AND etab_id = :etab_id");
$result = $statement->execute(array('cock_id' => $cockId, 'etab_id' => $etabId));
$select_cock_etab_id = $statement->fetch();
$cockEtabId = $select_cock_etab_id[0];
$pdo = NULL;