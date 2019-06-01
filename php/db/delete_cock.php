<!-- Mit diesem SQL Statement werden Cocktails gelöscht -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "DELETE 
     FROM cock
     WHERE id = :id");
$result = $statement->execute(array('id' => $cockId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Cocktail erfolgreich gelöscht!";
 } else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler aufgetreten.";
 }