<?php
include('./db/_openConnection.php');

if (isset($_GET['etab_id'])) {
    $result = $pdo->prepare("SELECT img FROM etab where id = :etab_id");
    if ($result->execute(array('etab_id' => $_GET['etab_id']))) {
        $imgFetch = $result->fetch();
        echo $imgFetch[0];
        
    } 
}
elseif (isset($_GET['cock_id']))
{
	$result = $pdo->prepare("SELECT img FROM cock WHERE id = :cock_id");
	if ($result->execute(array('cock_id' => $_GET['cock_id'])))
	{
		$imgFetch = $result->fetch();
		echo $imgFetch[0];
	}
}
?>