<?php
if (isset($_SESSION['userId']) && !isset($_SESSION['showUser'])) {
   $userId = $_SESSION['userId'];
} elseif (isset($_SESSION['showUser'])) {
   $userId = $_SESSION['showUser'];
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
		JOIN cock_etab ce
			ON bew_cock.cock_etab_id = ce.id
        JOIN cock 
        ON ce.cock_id = cock.id 
        JOIN etab 
        ON ce.etab_id = etab.id 
     WHERE bew_cock.user_id = :userId"
);
$result = $statement->execute(array('userId' => $userId));
$user_bewCock = $statement->fetchAll();
for ($i = 0; $i < count($user_bewCock); $i++) {
   $user_bewCock[$i]["ts"] = date("d.m.Y", strtotime($user_bewCock[$i]['ts']));
}
$pdo = NULL;
$_SESSION['showUser'] = NULL;
