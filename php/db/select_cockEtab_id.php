<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
if (isset($cockId)) {
    $statement = $pdo->prepare(
        "SELECT etab_id 
         FROM cock_etab 
         WHERE cock_id =:cockid"
    );
    $result = $statement->execute(array('cockid' => $cockId));
} else {
    $statement = $pdo->prepare(
        "SELECT cock_id 
         FROM cock_etab 
         WHERE etab_id =:etabid"
    );
    $result = $statement->execute(array('etabid' => $etabId));
}
$select_cockEtab_id = $statement->fetchAll();
$pdo = NULL;
