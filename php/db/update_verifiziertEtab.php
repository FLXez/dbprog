<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("UPDATE etab SET verifiziert = :verifiziert   WHERE id= :etab_id");
$result = $statement->execute(array('verifiziert' => $verifizierung ,'etab_id'=> $etabid));
$pdo=NULL;
?>