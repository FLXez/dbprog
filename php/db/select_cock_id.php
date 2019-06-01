<!-- Dieses SQL Statement gibt die ID eines Cocktails zurück -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=tbec', 'root', '');
$statement = $pdo->prepare(
    "SELECT id as id
     FROM cock 
     where name = :name");
$result = $statement->execute(array('name' => $cockName));
$select_cock_id = $statement->fetch();
$pdo = NULL;