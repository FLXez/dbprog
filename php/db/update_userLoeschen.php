<?php
session_start();
if($_SESSION['admin']==2){
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
                                                admin = :admin 
                                                WHERE id = :userid");
    $result = $statement->execute(array('username' => "User gelöscht", 'passwort'=> "NaN",'email'=>"deleted@deleted.de", 'img'=>"",'admin'=>-1, 'userid'=> $_SESSION['changeAdmin_userid']));
}

header("Location: ../" . $_SESSION['source']);
?>