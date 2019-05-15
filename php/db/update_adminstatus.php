<?php
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("UPDATE user SET admin = :admin   WHERE id= :user_id");
$result = $statement->execute(array('admin' => $admin ,'user_id'=> $userid));
$pdo=NULL;
?>