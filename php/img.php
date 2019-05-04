<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

if (isset($_GET['eta_id'])) {
    $result = $pdo->prepare("SELECT img FROM etablissement where id = :eta_id");
    if ($result->execute(array('eta_id' => $_GET['eta_id']))) {
        $imgFetch = $result->fetch();
        echo $imgFetch[0];
        
    } 
}
elseif (isset($_GET['cock_id']))
{
	$result = $pdo->prepare("SELECT img FROM cocktail WHERE id = :cock_id");
	if ($result->execute(array('cock_id' => $_GET['cock_id'])))
	{
		$imgFetch = $result->fetch();
		echo $imgFetch[0];
	}
}
?>