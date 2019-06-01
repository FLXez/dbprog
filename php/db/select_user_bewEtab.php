<!-- Dieses SQL Statement liefert eine Liste aller Etablissement-Bewertungen eines Users -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT bew_etab.timestamp as ts
           ,etab.name as name
           ,etab.id as id
           ,bew_etab.text as text
           ,bew_etab.wert as wert
           ,bew_etab.id as bew_id
     FROM bew_etab 
        JOIN etab 
        ON bew_etab.etab_id = etab.id 
     WHERE bew_etab.user_id = :userId");
$result = $statement->execute(array('userId' => $userId));
$user_bewEtab = $statement->fetchAll();
for ($i = 0; $i < count($user_bewEtab); $i++) {
    $user_bewEtab[$i]["ts"] = date("d.m.Y",strtotime($user_bewEtab[$i]['ts']));
}
$pdo = NULL;