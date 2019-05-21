<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['admin']) {
        if ($_GET['bew'] == "etab") {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewEtab.php');
        } elseif ($_GET['bew'] == "cock") {
            $bew_id = $_GET['bew_id'];
            include('db/delete_bewCock.php');
        }
    }
}
header("Location: " . $_SESSION['source']);
