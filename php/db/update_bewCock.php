<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE bew_cock 
     SET wert=:wert
        ,text=:kommentar 
     WHERE user_id=:user_id 
       AND etab_id=:etab_id 
       AND cock_id=:cock_id"
);
$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $userid, 'etab_id' => $bew_etab, 'cock_id' => $cockid));
$pdo = NULL;
