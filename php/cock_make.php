<?php
session_start();
if (isset($_SESSION['userId'])) {

    $cockName = $_POST['cockName'];
    $cockDesc = $_POST['cockDesc'];
    $etabId = $_POST['etab'];
    $preis = $_POST['preis'];

    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_tem_loc = $_FILES['file']['tmp_name'];

    if ($file_name) {
        $handle = fopen($file_tem_loc, 'r');
        $image = fread($handle, $file_size);
    } else {
        $image = "";
    }

    include('db/check_cock.php');

    if (!$cock_vorhanden) {
        include('db/insert_cock.php');
        $modId = $_SESSION['userId'];
        $aktion = "cock_new";
        include('db/insert_log.php');
    }

    include('db/select_cock_id.php');
    if ($result) {
        $cockId = $select_cock_id['id'];
    }
    include('db/check_cock_etab.php');
    if (!$cock_etab_vorhanden) {
        include('db/insert_cockEtab.php');
        $modId = $_SESSION['userId'];
        $aktion = "cock_etab_new";
        include('db/insert_log.php');
    } else {
        $_SESSION['message'] = "Cocktail ist in dem Etablissement bereits vorhanden!";
    }
}
if (isset($cockId)) {
    header("Location: ../site/cocktail_details.php?cock_id=" . $cockId);
} else {
    header("Location: " . $_SESSION['source']);
}
