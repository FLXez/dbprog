<?php
session_start();

$file_name = $_FILES['file']['name'];
$file_type = $_FILES['file']['type'];
$file_size = $_FILES['file']['size'];
$file_tem_loc = $_FILES['file']['tmp_name'];

if ($file_name) {
    $handle = fopen($file_tem_loc, 'r');
    $image = fread($handle, $file_size);
} else {
    $image = "";
}

$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "UPDATE user   
         SET img = :img, 
             updated_at = CURRENT_TIMESTAMP  
         WHERE id = :userId"
);
$result = $statement->execute(array('img' => $image, 'userId' => $_SESSION['userId']));
$pdo = NULL;

if ($result) {
    $_SESSION['message'] = "Dein Bild wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim aktualisieren des Bildes aufgetreten.";
}

header("Location: " . $_SESSION['source']);
