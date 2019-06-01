<!-- Dieses PHP Subscript händelt das Löschen von Usern -->
<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $userId = $_GET['userId'];
        if ($_GET['soft'] == 1) {
            include('db/delete_user_soft.php');
        } else {
            include('db/delete_user.php');
        }
    }
}
header("Location: ../site/profil_meldung.php");
