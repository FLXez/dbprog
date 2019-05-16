<?php
$filter = "%" . $_POST['search'] . "%";

include('../php/db/select_card_info.php');

if (count($cardCock) == 0 && count($cardEtab) == 0) {
    $_SESSION['error'] = true;
    $_SESSION['message'] = "Keine Übereinstimmungen.";
} else {
    $_SESSION['message'] = "Suchergebnisse werden unten angezeigt!";
}
