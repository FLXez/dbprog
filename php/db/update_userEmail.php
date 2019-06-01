<!-- Mit diesem SQL Statement wird die Mail-Adresse eines Users bearbeitet -->
<?php
session_start();

//Passwort aus der Datenbank ziehen.
include('select_userPrivate.php');
//Wird die gewünschte neue Email bereits verwendet?
$newEmail = $_POST['u_ue_emailNew'];
include('check_email.php');

if ($email_vorhanden) {
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Die E-Mail Addresse ist bereits einem User zugewiesen.";

   //gewünschte Email frei, Passwort korrekt?
} elseif (password_verify($_POST['u_ue_password'], $userPrivate['passwort'])) {
   $pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
   $statement = $pdo->prepare(
      "UPDATE user 
     SET email = :email 
        ,updated_at = CURRENT_TIMESTAMP 
     WHERE id = :userId"
   );
   $result = $statement->execute(array('email' => $_POST['u_ue_emailNew'], 'userId' => $_SESSION['userId']));
   $pdo = NULL;

   if ($result) {
      $_SESSION['message'] = "Die E-Mail Addresse wurde erfolgreich geändert.";
   } else {
      $_SESSION['error'] = true;
      $_SESSION['message'] = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
   }
} else {
   //Passwort ist falsch
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Das Passwort ist falsch.";
}
header("Location: " . $_SESSION['source']);
