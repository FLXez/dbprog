<!-- Dieses PHP Subscript händelt das Bearbeiten von Etablissements -->
<?php
session_start();
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] >= 1) {

        $ort = $_POST['etab_ort'];
        $anschrift = $_POST['etab_anschrift'];
        $name = $_POST['etab_name'];
        $etabId = $_GET['etab_id'];

        include('db/select_etabInfo.php');

        include('db/check_etab.php');
        if (!$etab_vorhanden) {

            $file_name = $_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $file_size = $_FILES['file']['size'];
            $file_tem_loc = $_FILES['file']['tmp_name'];

            if ($file_name) {
                $handle = fopen($file_tem_loc, 'r');
                $img = fread($handle, $file_size);
            } else {
                $img = $etabInfo['img'];
            }

            include('db/update_etab.php');

            $modId = $_SESSION['userId'];
            $aktion = "etab_edit";
            include('db/insert_log.php');
        }
    }
}
header("Location: " . $_SESSION['source']);