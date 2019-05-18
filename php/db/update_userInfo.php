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
$_SESSION['message'] = "Informationen aktualisiert!";
$pdo = NULL;
header("Location: ../".$_SESSION['source']);
