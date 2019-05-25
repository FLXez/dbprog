<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_GET['bew'] == "etab") {
        if ($_SESSION['rang'] == 2) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewEtab.php');
        } elseif ($_GET['userId'] == $_SESSION['userId']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewEtab.php');
        }
    } elseif ($_GET['bew'] == "cock") {
        if ($_SESSION['rang'] == 2) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewCock.php');
        } elseif ($_GET['userId'] == $_SESSION['userId']) {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewCock.php');
        }
    }
}
header("Location: " . $_SESSION['source']);
