<?php
session_start();
$username = $_POST['login_username'];
//select Passwort von dem Username
include('db/select_userPrivate.php');
//User existent und Passwort richtig.
if ($userPrivate !== false && password_verify($_POST['login_passwort'], $userPrivate['passwort'])) {
    $_SESSION['userId'] = $userPrivate['userId'];
    $_SESSION['admin'] = $userPrivate['admin'];
    if (isset($_SESSION['source'])) {
        header("Location:" . $_SESSION['source']);
    } else {
        header("../site/index.php");
    }
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Username oder/und Passwort ungültig!";
    header("Location: ../site/signin.php");
}