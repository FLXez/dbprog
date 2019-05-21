<?php
session_start();
if (isset($_SESSION['userId'])) {
    if (isset($_GET['etab_id'])) {
        $etabId = $_GET['etab_id'];
        $userId = $_SESSION['userId'];

        include('db/check_bewEtab.php');

        $bew_wert = $_POST['wert'];
        $bew_kommentar = $_POST['kommentar'];

        if ($bew_vorhanden) {
            include('../php/db/update_bewEtab.php');
        } else {
            include('../php/db/insert_bewEtab.php');
        }
    } elseif (isset($_GET['cock_id'])) {
        $etabId = $_POST['eta'];
        $cockId = $_GET['cock_id'];
        $userId = $_SESSION['userId'];

        include('../php/db/check_bewCock.php');

        $bew_wert = $_POST['wert'];
        $bew_kommentar = $_POST['kommentar'];

        if ($bew_vorhanden) {
            include('../php/db/select_cock_etab_id.php');
            $cockEtabId = $select_cock_etab_id['ce_id'];
            include('../php/db/update_bewCock.php');
        } else {
            include('../php/db/select_cock_etab_id.php');
            $cockEtabId = $select_cock_etab_id['ce_id'];
            include('../php/db/insert_bewCock.php');
        }
    }
    if ($result) {
        $_SESSION['message'] = "Bewertung erfolgreich abgegeben!";
    } else {
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
    }
}
header("Location: " . $_SESSION['source']);
