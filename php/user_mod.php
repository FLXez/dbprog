<?php
session_start();

$changeAdmin = 1;

$userId = $_SESSION['changeAdmin_userId'];

include('db/update_userMod.php');

if ($result) {
    $_SESSION['message'] = "Modstatus wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Aktualisieren des Modstatusses aufgetreten.";
}

$_SESSION['changeAdmin_userId'] = NULL;
header("Location: " . $_SESSION['source']);
