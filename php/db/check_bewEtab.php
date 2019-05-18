<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM bew_etab
     WHERE user_id=:user_id 
     AND etab_id=:etab_id "
);
$result = $statement->execute(array('user_id' => $userId, 'etab_id' => $etabId));
$bew_vorhanden = $statement->fetch();
$pdo = NULL;
