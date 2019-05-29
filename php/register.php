<?php
session_start();

if ($_POST['register_passwort'] != $_POST['register_passwort_confirm']) {
    $_SESSION['message'] = "Die Passwörter stimmen nicht überein.<br>";
    $_SESSION['error'] = true;
}
//Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
$newEmail = $_POST['register_email'];
include('db/check_email.php');
if ($email_vorhanden) {
    $_SESSION['message'] .= "Diese E-Mail-Adresse ist bereits vergeben.<br>";
    $_SESSION['error'] = true;
}
$newUsername = $_POST['register_username'];
include('db/check_username.php');
if ($username_vorhanden) {
    $_SESSION['message'] .= "Dieser Username ist bereits vergeben.<br>";
    $_SESSION['error'] = true;
}

//Keine Fehler, wir können den Nutzer registrieren
if (!isset($_SESSION['error'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
    $passHash = password_hash($_POST['register_passwort'], PASSWORD_DEFAULT);
    $statement = $pdo->prepare(
        "INSERT INTO user (email, passwort, username) 
         VALUES (:email, :passwort, :username)"
    );
    $result = $statement->execute(array('email' => $_POST['register_email'], 'passwort' => $passHash, 'username' => $_POST['register_username']));
    $pdo = NULL;
    if ($result) {
        $_SESSION['message'] = "Du wurdest erfolgreich registriert.";
    } else {
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
    }
}
header("Location: ../site/signin.php");
