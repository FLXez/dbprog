<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
if (isset($_GET['eta_img_id'])) {
    $result = $pdo->prepare("SELECT img FROM etablissement_img where id = :img_id");
    if ($result->execute(array('img_id' => $_GET['eta_img_id']))) {
        $imgFetch = $result->fetch();
        echo $imgFetch[0];
        
    } 
}
elseif (isset($_GET['cock_img_id']))
{
	$result = $pdo->prepare("SELECT img FROM cocktail_img WHERE id = :img_id");
	if ($result->execute(array('img_id' => $_GET['cock_img_id'])))
	{
		$imgFetch = $result->fetch();
		echo $imgFetch[0];
	}
}
?>