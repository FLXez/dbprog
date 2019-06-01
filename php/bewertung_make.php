<!-- Dieses PHP Subscript stellt die Funktionen bereit, um Bewertungen abzugeben -->
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
            include('db/update_bewEtab.php');
        } else {
            include('db/insert_bewEtab.php');
        }
    } elseif (isset($_GET['cock_id'])) {
        $etabId = $_POST['eta'];
        $cockId = $_GET['cock_id'];
        $userId = $_SESSION['userId'];

        include('db/check_bewCock.php');

        $bew_wert = $_POST['wert'];
        $bew_kommentar = $_POST['kommentar'];

        if ($bew_vorhanden) {
            include('db/select_cock_etab_id.php');
            $cockEtabId = $select_cock_etab_id['ce_id'];
            include('db/update_bewCock.php');
        } else {
            include('db/select_cock_etab_id.php');
            $cockEtabId = $select_cock_etab_id['ce_id'];
            include('db/insert_bewCock.php');
        }
    }
}
header("Location: " . $_SESSION['source']);
