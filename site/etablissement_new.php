<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";
  

if($angemeldet){
$pdo = new PDO('mysql:host=localhost;dbname=dbprog','root','');
$insertError = false;
$notNewError = false;
$message = "";




	if(isset($_GET['newEtab'])){

			$nameEtab = $_POST['nameEtab'];
			$strasse = $_POST['strasseEtab'];
			$plzStadt = $_POST['plzStadtEtab'];

			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tem_loc = $_FILES['file']['tmp_name']; 

			$handle = fopen($file_tem_loc,'r');
			$content = fread($handle, $file_size);

			$statement = $pdo->prepare("Select * From etablissement WHERE name = :name AND anschrift =:anschrift");
			$result = $statement -> execute(array('name'=>$nameEtab, 'anschrift' => $strasse));
			$notNewError = $statement -> fetch();
			
			if($notNewError == false){
				$statement = $pdo ->prepare("INSERT INTO etablissement(name, ort, anschrift, img) VALUES (:name, :ort, :anschrift, :img)");
				$result = $statement ->execute(array('name' => $nameEtab, 'ort' => $plzStadt , 'anschrift' => $strasse, 'img'=> $content));
				$insertError = $statement -> fetch();

					if($insertError == false){
						$message = "Erfolgreich angelegt";				
					}else{
					$message = "Ein technsicher Fehler ist aufgetreten";
					}
			}else{
				$message ="Dieses Etablissement ist bereits vorhanden.";
			}	
			
	}
}



?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Etablissement - Neues Etablissement</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS Toolbox -->
    <link href="../css/csstoolbox.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php
        include('../php/buildHeader.php');
        ?>
    </header>
   
        <main role="main">
						<?php
							if($angemeldet){
							if ($notNewError or $insertError) {
								echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
								echo $message;
								echo '</div>';
							} 
            echo '<div class="mt-5 ml-5 mr-5">
                <div class="card card-body">
                    <h2 class="ml-4">Neues Etablissement</h2>

						<div class="mr-5 ml-5 mt-2">

						<form action="?newEtab=1" method="POST" enctype="multipart/form-data">
						
						<div class="form-group">
							<label for="nameEtab"> Name </label>
							<input type="text" maxlength="50" class="form-control" id="nameEtab" name="nameEtab"  placeholder="Etablissement" required>
						</div>

						<div class="form-group">
							<label for="image"> Bild </label>
							<br>
							<input type="file" name="file"> 	
						</div>

						<div class="form-group">
							<label for="adresseEtab"> Adresse </label>
							<input type="text" maxlength="50" class="form-control" id="strasseEtab" name="strasseEtab"  placeholder="Stra&szlig;e" required>
							<input type="text" maxlength="50" class="form-control" id="plzStadtEtab" name="plzStadtEtab"  placeholder="Postleitzahl Stadt" required>
						</div>

						<div class="form-group">
							<br>
							<button type="submit" class="btn btn-primary"> Erstellen</button>
						</div>
						</form>



						
						';



						}else{
							echo '<h2 class="ml-4 ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2>';
						}					
						echo'
                    <hr>
                </div>
            </div>'
						?>
        </main>
        <hr class="ct-hr-divider ml-5 mr-5">
        <footer role="footer" class="container">
            <?php
            include('../php/buildFooter.php');
            ?>
        </footer>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>