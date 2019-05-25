<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $meldId = $_GET['meld_id'];
        include('db/select_meldung_uuid.php');
        if ($meld_uuid[0] == $_SESSION['userId']) {
            $_SESSION['message'] = "Du kannst Meldungen über dich nicht löschen!";
            $_SESSION['error'] = true;
        } else {
            include('db/delete_meldung.php');
        }
    } elseif ($_SESSION['rang'] == 1) {
        $meldId = $_GET['meld_id'];
        include('db/select_meldung_muid.php');
        if ($meld_muid[0] == $_SESSION['userId']) {
            include('db/delete_meldung.php');
        }
    }
}
header("Location: " . $_SESSION['source']);
