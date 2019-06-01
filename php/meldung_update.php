<!-- In diesem PHP Subscript wird das Updaten von Meldungen behandelt -->
<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] == 2) {
        $meldId = $_GET['meld_id'];
        $status = $_GET['status'];
        include('db/select_meldung_uuid.php');
        if ($meld_uuid[0] == $_SESSION['userId']) {
            $_SESSION['message'] = "Du kannst Meldungen über dich nicht updaten!";
            $_SESSION['error'] = true;
        } else {
            include('db/update_meldung.php');
        }
    }
}
header("Location: " . $_SESSION['source']);
