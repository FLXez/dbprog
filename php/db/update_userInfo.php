<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
      "UPDATE user 
     SET vorname = :vorname
        ,nachname = :nachname
        ,age = :age
        ,beruf = :beruf 
        ,updated_at = CURRENT_TIMESTAMP 
     WHERE id = :userId");
$result = $statement->execute(array('vorname' => $_POST['u_ui_vname'], 'nachname' => $_POST['u_ui_nname'], 'age' => $_POST['u_ui_age'], 'beruf' =>  $_POST['u_ui_beruf'], 'userId' => $_SESSION['userId']));
$pdo = NULL;
if ($result) {
   $_SESSION['message'] = "Informationen aktualisiert!";
} else {
   $_SESSION['error'] = true;
   $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
}
header("Location: ../".$_SESSION['source']);
