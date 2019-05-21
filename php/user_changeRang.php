<?php
session_start();

if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $rang = $_GET['newRang'];
        $userId = $_GET['userId'];
        include('db/update_userRang.php');
    } elseif ($_SESSION['rang'] == 1) {
        $rang = 0;
        $userId = $_SESSION['userId'];
        include('db/update_userRang.php');
        $_SESSION['rang'] = 0;
    }
}
header("Location: " . $_SESSION['source']);