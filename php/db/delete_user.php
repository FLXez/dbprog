<!-- Mit diesem SQL Statement werden User Hart gelöscht (Kaskadieren, also auch alle Bewertungen) -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM user
     WHERE id = :id");
$result = $statement->execute(array('id' => $userId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "User erfolgreich entfernt!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }