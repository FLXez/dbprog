<!-- Dieses PHP Subscript bietet die Funktionalitäten der Meldefunktion --> 
<?php
session_start();
include('db/check_meldung.php');

if (isset($_SESSION['userId'])) {
    $melderId = $_SESSION['userId'];
    if (isset($_GET['meldungArt'])) {
        $meldungArt = $_GET['meldungArt'];
        if ($meldungArt == "user") {
            $userId = $_GET['userId'];
            $etabId = NULL;
            $cockId = NULL;
            check_meld_user($userId);
        } elseif ($meldungArt == "etab") {
            $userId = NULL;            
            $etabId = $_GET['etabId'];
            $cockId = NULL;
            check_meld_etab($etabId);
        } elseif ($meldungArt == "etab_bew") {
            $userId = $_GET['userId'];
            $etabId = $_GET['etabId'];
            $cockId = NULL;
            check_meld_etabBew($etabId, $userId);
        } elseif ($meldungArt == "cock") {
            $userId = NULL;
            $etabId = NULL;
            $cockId = $_GET['cockId'];
            check_meld_cock($cockId);
        } elseif ($meldungArt == "cock_bew") {
            $userId = $_GET['userId'];
            $etabId = NULL;            
            $cockId = $_GET['cockId'];
            check_meld_cockBew($cockId, $userId);
        }
        if ($meldung_vorhanden) {
            $_SESSION['message'] = "Eintrag wurde bereits gemeldet!";
            $_SESSION['error'] = true;
        } else {
            include('db/insert_meldung.php');
        }
    }
}
header("Location: " . $_SESSION['source']);