<!-- Mit diesem SQL Statement werden neue Cocktails in die Datenbank geschrieben -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "INSERT 
     INTO cock(name, beschreibung, img) 
     VALUES (:name, :beschreibung, :img)");
$result = $statement->execute(array('name' => $cockName, 'beschreibung' => $cockDesc, 'img' => $image));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Erfolgreich hinzugefügt!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }