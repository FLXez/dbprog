<?php
session_start();
if(isset($_SESSION['userId'])){
    if(isset($_GET['cock_id']) && isset($_POST['zu_etab']) && isset($_POST['preis']))

    $cockId = $_GET['cock_id'];
    $etabId = $_POST['zu_etab'];     
    $preis = $_POST['preis'];

    include('db/insert_cockEtab.php');
    $modId = $_SESSION['userId'];
    $aktion = "cock_etab_new";
    include('db/insert_log.php');
}
header("Location: " . $_SESSION['source']);