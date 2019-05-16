<?php
session_start();

if (isset($_SESSION['degradeSelf'])) {
    $userid = $_SESSION['userid'];
    $changeAdmin = 0;
    $_SESSION['admin'] = 0;
} else {
    $userid = $_SESSION['changeAdmin_userid'];
    $changeAdmin = $_SESSION['changeAdmin_pos'];
}

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
    "UPDATE user 
        SET admin = :admin   
     WHERE id= :user_id"
);
$result = $statement->execute(array('admin' => $changeAdmin, 'user_id' => $userid));
if ($result) {
    $_SESSION['message'] = "Modstatus wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Aktualisieren des Modstatusses aufgetreten.";
}
$pdo = NULL;
$_SESSION['changeAdmin_userid'] = NULL;
$_SESSION['changeAdmin_pos'] = NULL;
$_SESSION['degradeSelf'] = NULL;
header("Location: ../" . $_SESSION['source']);