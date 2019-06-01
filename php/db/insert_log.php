<!-- mit diesem SQL Statement werden Log-Nachrichten in die Datenbank geschrieben -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "INSERT INTO log 
        (mod_id, aktion, etab_id, cock_id)
     VALUES
        (:mod_id, :aktion, :etab_id, :cock_id);"
);
$result = $statement->execute(array('mod_id' => $modId, 'aktion' => $aktion, 'etab_id' => $etabId, 'cock_id' => $cockId));
$pdo = NULL;
