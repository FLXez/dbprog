<!-- Dieses PHP Subscript stellt abhängig der Session Variable 'error' eine Fehler- oder Info-Meldung dar -->
<?php
if (isset($_SESSION['message'])) {
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
        echo $_SESSION['message'];
        echo '</div>';
        $_SESSION['error'] = NULL;
    } else {
        echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
        echo $_SESSION['message'];
        echo '</div>';
    }
    $_SESSION['message'] = NULL;
}
