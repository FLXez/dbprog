<!-- Dieses SQL Statement gibt eine Liste aller Etablissements zurück -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT id
		   ,name
		   ,ort
     FROM etab");
$result = $statement->execute();
$allEtab = $statement->fetchAll();
$pdo = NULL;
