<!-- Mit diesem SQL Statement wird der Rang eines Users bearbeitet (0=User, 1=Mod, 2=Admin) -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "UPDATE user 
        SET rang = :rang   
     WHERE id= :user_id"
);
$result = $statement->execute(array('rang' => $rang, 'user_id' => $userId));
$pdo = NULL;
if ($result) {
    $_SESSION['message'] = "Rang wurde aktualisiert.";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Aktualisieren des Rangs aufgetreten.";
}