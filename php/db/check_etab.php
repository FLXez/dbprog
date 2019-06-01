<!-- Dieses SQL Statement überprüft, ob ein Etablissement bereits vorhanden ist -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM etab  
     WHERE name = :name 
       AND anschrift =:anschrift
       AND ort =:ort");
$result = $statement->execute(array('name' => $name, 'anschrift' => $anschrift, 'ort' => $ort));
$etab_vorhanden = $statement->fetch();
$pdo = NULL;
