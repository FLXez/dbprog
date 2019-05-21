<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_GET['bew'] == "etab") {
        if ($_SESSION['admin']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewEtab.php');
        } elseif ($_GET['userId'] == $_SESSION['userId']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewEtab.php');
        }
    } elseif ($_GET['bew'] == "cock") {
        if ($_SESSION['admin']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewCock.php');
        } elseif ($_GET['userId'] == $_SESSION['userId']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewCock.php');
        }
    }
    if ($result) {
        $_SESSION['message'] = "Bewertung erfolgreich gelöscht!";
    } else {
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
    }
}
header("Location: " . $_SESSION['source']);
