<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] >= 1) {
  
        $beschreibung = $_POST['cock_beschreibung'];
        $name = $_POST['cock_name'];
        $cockId = $_GET['cock_id'];

        include('db/select_cockInfo.php');

        include('db/check_cock.php');
        if (!$cock_vorhanden) {

            $file_name = $_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $file_size = $_FILES['file']['size'];
            $file_tem_loc = $_FILES['file']['tmp_name'];

            if ($file_name) {
                $handle = fopen($file_tem_loc, 'r');
                $img = fread($handle, $file_size);
            } else {
                $img = $cockInfo['img'];
            }

            include('db/update_cock.php');

            $modId = $_SESSION['userId'];
            $aktion = "cock_edit";
            include('db/insert_log.php');
        }
    }
}
header("Location: " . $_SESSION['source']);