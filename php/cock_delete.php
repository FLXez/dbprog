<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $cockId = $_GET['cockId'];
        include('db/delete_cock.php');
    }
}
header("Location: ../site/profil_meldung.php");