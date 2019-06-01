<!-- Dieses PHP Subscript stellt Funktionen bereit, die in der Datenbank überprüfen, ob bereits Meldungen vorhanden sind -->
<?php
function check_meld_user($userId)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $statement = $pdo->prepare(
        "SELECT '1'
         FROM meldung
         WHERE cock_id IS NULL
           AND etab_id IS NULL
           AND meldung_art = 'user'
           AND status = 0
           AND user_id= :user_id"
    );
    $result = $statement->execute(array('user_id' => $userId));
    $GLOBALS['meldung_vorhanden'] = $statement->fetch();
    $pdo = NULL;
}

function check_meld_etab($etabId)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $statement = $pdo->prepare(
        "SELECT '1'
         FROM meldung
         WHERE cock_id IS NULL
           AND etab_id = :etab_id 
           AND meldung_art = 'etab'
           AND status = '0'
           AND user_id= IS NULL"
    );
    $result = $statement->execute(array('etab_id' => $etabId));
    $GLOBALS['meldung_vorhanden'] = $statement->fetch();
    $pdo = NULL;
}

function check_meld_etabBew($etabId, $userId)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $statement = $pdo->prepare(
        "SELECT '1'
         FROM meldung
         WHERE cock_id IS NULL
           AND etab_id = :etab_id 
           AND meldung_art = 'etab_bew'
           AND status = 0
           AND user_id= :user_id"
    );
    $result = $statement->execute(array('etab_id' => $etabId, 'user_id' => $userId));
    $GLOBALS['meldung_vorhanden'] = $statement->fetch();
    $pdo = NULL;
}



function check_meld_cock($cockId)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $statement = $pdo->prepare(
        "SELECT '1'
         FROM meldung
         WHERE cock_id = :cock_id
           AND etab_id IS NULL
           AND meldung_art = 'cock'
           AND status = 0
           AND user_id IS NULL"
    );
    $result = $statement->execute(array('cock_id' => $cockId));
    $GLOBALS['meldung_vorhanden'] = $statement->fetch();
    $pdo = NULL;
}

function check_meld_cockBew($cockId, $userId)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $statement = $pdo->prepare(
        "SELECT '1'
         FROM meldung
         WHERE cock_id = :cock_id
           AND etab_id IS NULL
           AND meldung_art = 'cock_bew'
           AND status = 0
           AND user_id= :user_id"
    );
    $result = $statement->execute(array('cock_id' => $cockId, 'user_id' => $userId));
    $GLOBALS['meldung_vorhanden'] = $statement->fetch();
    $pdo = NULL;
}
