<!-- Dieses SQL Statement gibt eine Liste von IDs zur�ck. 
Wenn Cocktails gefordert sind, werden alle IDs von Etablissements zur�ckgegeben, in denen der Cocktail angeboten wird. 
Andersrum analog. -->
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
