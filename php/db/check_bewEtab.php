<!-- Durch dieses SQL Statement wird überprüft, ob der User bereits eine Bewertung zu diesem Etablissement abgegeben hat -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT '1' 
     FROM bew_etab
     WHERE user_id=:user_id 
     AND etab_id=:etab_id "
);
$result = $statement->execute(array('user_id' => $userId, 'etab_id' => $etabId));
$bew_vorhanden = $statement->fetch();
$pdo = NULL;
