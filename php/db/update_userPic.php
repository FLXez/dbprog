<?php 
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare(
                        "UPDATE
                        user   
                        SET 
                        img = :img, 
                        updated_at = CURRENT_TIMESTAMP  
                        WHERE 
                        id = :userid");
$result = $statement->execute(array('img'=> $image, 'userid' => $userid));
$pdo =NULL;
?>