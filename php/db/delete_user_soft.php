<!-- Mit diesem SQL Statement werden User Soft gelöscht (Also im Endeffekt nur Umbenannt, um die Bewertungen zu erhalten) -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
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
$result = $statement->execute(array('username' => "User gelöscht", 'passwort' => "NaN", 'email' => "deleted", 'img' => "", 'rang' => -1, 'userid' => $userId));

if ($result) {
    $_SESSION['message'] = "User erfolgreich gelöscht!";
} else {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Es ist ein Fehler beim Löschen des Users aufgetreten.";
}
