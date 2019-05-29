<?php
session_start();

//Passwort aus der Datenbank ziehen.
include('select_userPrivate.php');

//Eingaben für das neue Passwort übereinstimmend?
if ($_POST['u_up_passNew'] != $_POST['u_up_passNew_confirm']) {
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Die Eingaben für das neue Passwort stimmen nicht überein.<br>";
} elseif (password_verify($_POST['u_up_passOld'], $userPrivate['passwort'])) {
   //Passwort updaten
   $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
   $passHash = password_hash($_POST['u_up_passNew'], PASSWORD_DEFAULT);
   $statement = $pdo->prepare(
      "UPDATE user 
        SET passwort = :passwort
           ,updated_at = CURRENT_TIMESTAMP 
        WHERE id = :userId"
   );
   $result = $statement->execute(array('passwort' => $passHash, 'userId' => $_SESSION['userId']));
   $pdo = NULL;

   if ($result) {
      $_SESSION['message'] = "Dein Passwort wurde erfolgreich geändert!";
   } else {
      $_SESSION['error'] = true;
      $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
   }
} else {
   //Passwort ist falsch.
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Das Passwort ist faslch.";
}

header("Location: " . $_SESSION['source']);