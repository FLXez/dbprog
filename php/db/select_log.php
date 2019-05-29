<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
       "SELECT l.id as id, 
               l.ts as lts, 
               l.mod_id as mod_id, 
               u.username as uname,                
               l.aktion as aktion, 
               l.etab_id as eid, 
               e.name as ename, 
               l.cock_id as cid, 
               c.name as cname
         FROM log l 
            LEFT JOIN cock c 
                ON c.id = l.cock_id 
            LEFT JOIN etab e 
                ON e.id = l.etab_id 
            LEFT JOIN user u
                ON u.id = l.mod_id
         ORDER BY l.ts DESC"
);
$result = $statement->execute();
$logInfo = $statement->fetchAll();
for ($i = 0; $i < count($logInfo); $i++) {
    $logInfo[$i]["lts"] = date("d.m.Y", strtotime($logInfo[$i]['lts']));
 }
$pdo = NULL;