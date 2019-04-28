<?php
//Ist eine Session offen?
session_start();

$angemeldet = false;

if (isset($_SESSION['username'])) {
    $angemeldet = true;
    $username = $_SESSION['username'];
} else {
    $angemeldet = false;
}
