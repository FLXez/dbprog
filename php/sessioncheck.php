<?php
//Ist eine Session offen?
session_start();

$angemeldet = false;

if (isset($_SESSION['userid'])) {
    $angemeldet = true;
} else {
    $angemeldet = false;
}
