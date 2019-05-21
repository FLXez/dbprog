<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] >= 1) {
        $verify = $_GET['newVerify'];
        $etabId = $_GET['etabId'];
        include('db/update_etabVerify.php');
    }
}
header("Location: " . $_SESSION['source']);