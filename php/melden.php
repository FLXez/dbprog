<?php
session_start();
if (isset($_SESSION['userId'])) {
    $melderId = $_SESSION['userId'];
    if (isset($_GET['meldungArt'])) {        
        $meldungArt = $_GET['meldungArt'];
        if ($meldungArt == "user") {
            $userId = $_GET['userId'];
        } elseif ($meldungArt == "etab") {
            $etabId = $_GET['etabId'];
        } elseif ($meldungArt == "etab_bew") {
            $userId = $_GET['userId'];
            $etabId = $_GET['etabId'];
        } elseif ($meldungArt == "cock") {
            $cockId = $_GET['cockId'];
        } elseif ($meldungArt == "cock_bew") {
            $userId = $_GET['userId'];
            $cockId = $_GET['cockId'];
        }
        include('db/insert_meldung.php');
    }
}
header("Location: " . $_SESSION['source']);