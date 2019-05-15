<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if (isset($cockid)) {
    $statement = $pdo->prepare(
        "SELECT etab_id 
         FROM cock_etab 
         WHERE cock_id =:cockid"
    );
    $result = $statement->execute(array('cockid' => $cockid));
} else {
    $statement = $pdo->prepare(
        "SELECT cock_id 
         FROM cock_etab 
         WHERE etab_id =:etabid"
    );
    $result = $statement->execute(array('etabid' => $etabid));
}
$select_cockEtab_id = $statement->fetchAll();
$pdo = NULL;
