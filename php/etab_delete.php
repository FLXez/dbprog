<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $etabId = $_GET['etabId'];
        include('db/delete_etab.php');
    }
}
header("Location: ../site/profil_meldung.php");