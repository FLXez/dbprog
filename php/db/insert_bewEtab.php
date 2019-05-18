<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "INSERT 
     INTO bew_etab (user_id, etab_id, wert, text) 
     VALUES (:user_id, :etab_id, :wert, :kommentar)");
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userId, 'etab_id' =>  $etabId));
$pdo = NULL;