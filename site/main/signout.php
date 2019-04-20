<?php
session_start();
session_destroy();
 
echo "Logout erfolgreich";
echo '<a href="index.php">zurück</a>';
?>