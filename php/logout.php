<!-- Dieses PHP Subscript h�ndelt den Logout-Vorgang -->
<?php
session_start();
$source = $_SESSION['source'];
session_destroy();

header("Location: " . $source);
