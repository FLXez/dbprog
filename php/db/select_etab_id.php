<!-- Dieses SQL Statement liefert die ID eines Etablissements zur�ck -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT id as id
     FROM etab 
     where name = :name");
$result = $statement->execute(array('name' => $etabName));
$select_etab_id = $statement->fetch();
$pdo = NULL;