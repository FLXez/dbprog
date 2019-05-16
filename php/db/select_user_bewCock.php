<?php
if (isset($_SESSION['userid']) && !isset($_SESSION['showUser'])) {
   $userid = $_SESSION['userid'];
} elseif (isset($_SESSION['showUser'])) {
   $userid = $_SESSION['showUser'];
}
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
   "SELECT bew_cock.timestamp as ts
           ,etab.name as etabname
           ,etab.id as etabid
           ,cock.name as cockname
           ,cock.id as cockid
           ,bew_cock.text as text
           ,bew_cock.wert as wert 
     FROM bew_cock 
        JOIN cock 
        ON bew_cock.cock_id = cock.id 
        JOIN etab 
        ON bew_cock.etab_id = etab.id 
     WHERE bew_cock.user_id = :userid"
);
$result = $statement->execute(array('userid' => $userid));
$user_bewCock = $statement->fetchAll();
for ($i = 0; $i < count($user_bewCock); $i++) {
   $user_bewCock[$i]["ts"] = date("d.m.Y", strtotime($user_bewCock[$i]['ts']));
}
$pdo = NULL;
$_SESSION['showUser'] = NULL;
