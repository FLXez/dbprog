<!-- Dieses SQL Statement gibt die Informationen eines bestimmten Cocktails zurück -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT 
        c.id as id,
        c.name as name,
        c.beschreibung as beschreibung,
        c.img as img
    FROM cock c
    WHERE c.id = :cock_id"
);
$result = $statement->execute(array('cock_id' => $cockId));
$cockInfo = $statement->fetch();
$pdo = NULL;
