<?php
if (isset($_SESSION['userid']) && !isset($_SESSION['showUser'])) {
   $userid = $_SESSION['userid'];
} elseif (isset($_SESSION['showUser'])) {
   $userid = $_SESSION['showUser'];
}
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "SELECT bew_etab.timestamp as ts
           ,etab.name as name
           ,etab.id as id
           ,bew_etab.text as text
           ,bew_etab.wert as wert
     FROM bew_etab 
        JOIN etab 
        ON bew_etab.etab_id = etab.id 
     WHERE bew_etab.user_id = :userid");
$result = $statement->execute(array('userid' => $userid));
$user_bewEtab = $statement->fetchAll();
for ($i = 0; $i < count($user_bewEtab); $i++) {
    $user_bewEtab[$i]["ts"] = date("d.m.Y",strtotime($user_bewEtab[$i]['ts']));
}
$pdo = NULL;
$_SESSION['showUser'] = NULL;