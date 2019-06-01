<!-- Dieses PHP Subscript händelt das Verifizieren von Etablissements -->
<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] >= 1) {
        $verify = $_GET['newVerify'];
        $etabId = $_GET['etabId'];
        include('db/update_etabVerify.php');
        $modId = $_SESSION['userId'];
        if($verify == 1) {
            $aktion = "etab_verify";
        } elseif ($verify == 0) {
            $aktion = "etab_unverify";
        }
        include('db/insert_log.php');
    }
}
header("Location: " . $_SESSION['source']);