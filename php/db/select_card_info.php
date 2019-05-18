<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if ($getEtab) {
      $statement = $pdo->prepare(
            "SELECT e.id as id
           ,e.name as name
           ,e.ort as ort
           ,e.anschrift as anschrift
           ,e.verifiziert as verifiziert
           ,AVG(sub_be.wert) as avgwert
           ,e.img as img
           ,count(sub_be.wert) as anz
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
             ,e.img"
      );
      $result = $statement->execute(array('name' => $filter));
      $cardEtab = $statement->fetchAll();
}
if ($getCock) {
      $statement = $pdo->prepare(
            "SELECT c.id as id
           ,c.name as name
           ,c.beschreibung as beschreibung
           ,c.img as img
           ,AVG(sub_bc.wert) as avgwert
           ,count(sub_bc.wert) as anz
     FROM cock c
     LEFT JOIN 
        (SELECT ce.cock_id
               ,CAST(bc.wert AS INTEGER) AS wert
         FROM bew_cock bc
		 JOIN cock_etab ce 
			ON bc.cock_etab_id = ce.id) sub_bc
        ON c.id = sub_bc.cock_id
     WHERE name LIKE :name
     GROUP BY c.id
             ,c.name
             ,c.beschreibung
             ,c.img"
      );
      $result = $statement->execute(array('name' => $filter));
      $cardCock = $statement->fetchAll();
}
$pdo = NULL;
