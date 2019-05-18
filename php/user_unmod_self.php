<?php
session_start();

$changeAdmin = 0;

$userid = $_SESSION['userid'];

include('db/update_userMod.php');

if ($result) {
    $_SESSION['message'] = "Modstatus wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Aktualisieren des Modstatusses aufgetreten.";
}
$pdo = NULL;
$_SESSION['admin'] = 0;
$_SESSION['changeAdmin_userid'] = NULL;
$_SESSION['changeAdmin_pos'] = NULL;
$_SESSION['degradeSelf'] = NULL;
header("Location: " . $_SESSION['source']);
