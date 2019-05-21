<?php
session_start();
if($_SESSION['rang']==2){
    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
    $statement = $pdo->prepare("UPDATE user SET username = :username,
                                                vorname = null,
                                                nachname = null,
                                                passwort = :passwort,
                                                email = :email,
                                                age = null,
                                                beruf = null,
                                                img = :img,
                                                updated_at = CURRENT_TIMESTAMP,
                                                rang = :rang 
                                                WHERE id = :userid");
    $result = $statement->execute(array('username' => "User gelöscht", 'passwort'=> "NaN",'email'=>"deleted@deleted.de", 'img'=>"",'rang'=>-1, 'userid'=> $userId));
}

if ($result) {
    $_SESSION['message'] = "Erfolgreich gelöscht!";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Löschen des Users aufgetreten.";
}

header("Location: ../" . $_SESSION['source']);
