<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if (isset($_GET['eta_img_id'])) {
    $result = $pdo->prepare("SELECT img FROM etablissement_img where id = :img_id");
    if ($result->execute(array('img_id' => $_GET['eta_img_id']))) {
        $imgFetch = $result->fetch();
        echo $imgFetch[0]; //this prints the image data, transforming the image.php to an image
        
    } 
}
	else {
	echo '../res/mexcal.jpg';
	}
// you can put an "else" here to do something on error...
?>