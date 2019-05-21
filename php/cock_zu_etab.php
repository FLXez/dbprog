<?php
session_start();
if(isset($_SESSION['userId'])){
    if(isset($_GET['cock_id']) && isset($_POST['zu_etab']) && isset($_POST['preis']))

    $cockId = $_GET['cock_id'];
    $etabId = $_POST['zu_etab'];     
    $preis = $_POST['preis'];

    include('db/insert_cockEtab.php');
}
header("Location: " . $_SESSION['source']);