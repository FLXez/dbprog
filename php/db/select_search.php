<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT e.id
           ,e.name
           ,e.ort
           ,e.anschrift
           ,e.verifiziert
           ,AVG(sub_be.wert)
           ,e.img
     FROM etab e
     LEFT JOIN 
        (SELECT be.etab_id
               ,CAST(be.wert AS INTEGER) AS wert
         FROM bew_etab be ) sub_be
        ON e.id = sub_be.etab_id
     WHERE name LIKE :name
     GROUP BY e.id
             ,e.name
             ,e.ort
             ,e.anschrift
             ,e.verifiziert
             ,e.img");
$result = $statement->execute(array('name' => $suchbegriff));
$foundEtab = $statement->fetchAll();

$statement = $pdo->prepare(
    "SELECT c.id
           ,c.name
           ,c.beschreibung
           ,c.img
           ,AVG(sub_bc.wert)
     FROM cock c
     LEFT JOIN 
        (SELECT bc.cock_id,
               ,CAST(bc.wert AS INTEGER) AS wert
         FROM bew_cock bc ) sub_bc
        ON c.id = sub_bc.cock_id
     WHERE name LIKE :name
     GROUP BY c.id
             ,c.name
             ,c.beschreibung
             ,c.img");
$result = $statement->execute(array('name' => $suchbegriff));
$foundCock = $statement->fetchAll();

$pdo = NULL;
?>