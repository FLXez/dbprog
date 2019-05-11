<?php
include('../php/sessioncheck.php');
$activeHead = "cocktail";
$_SESSION['source']= "Location: ../site/cocktail_new.php";

if ($angemeldet) {
	$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

	$insertError = false;
	$notNewError = false;
	$doubleError = false;

	$angelegt = false;
	$message = "";

	$statementEtabs = $pdo->prepare("SELECT id,
												name,
												ort
										FROM etablissement ");
		$etabResult = $statementEtabs->execute();
		$allEtabsPos = $statementEtabs->fetchAll();




	if (isset($_GET['newCock'])) {

		$nameCock = $_POST['nameCock'];
		$preisCock = $_POST['preisCock'];
		$etab_zuordn = $_POST['etab'];
		$beschreibungCock = $_POST['beschreibungCock'];

		$file_name = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		$file_size = $_FILES['file']['size'];
		$file_tem_loc = $_FILES['file']['tmp_name'];

		if($file_name){	
		$handle = fopen($file_tem_loc, 'r');
		$content = fread($handle, $file_size);
		}else{
			$content="";
		}

		$statement = $pdo->prepare("Select id From cocktail WHERE name = :name AND beschreibung = :beschreibung");
		$result = $statement->execute(array('name' => $nameCock, 'beschreibung' => $beschreibungCock));
		$notNewError = $statement->fetch();


		if ($notNewError == false) {
			$statement = $pdo->prepare("INSERT INTO cocktail(name, beschreibung, img) VALUES (:name, :beschreibung, :img)");
			$result = $statement->execute(array('name' => $nameCock, 'beschreibung' => $beschreibungCock, 'img' => $content));
			$insertError = $statement->fetch();


			$statement = $pdo-> prepare("SELECT id FROM cocktail where name = :name");
			$result = $statement -> execute(array('name'=> $nameCock));
			$idNewCock = $statement ->fetch();



			$statement = $pdo -> prepare("INSERT INTO cocktailkarte(eta_id, cocktail_id, preis) VALUES (:etab, :cocktail, :preis)");
			$result = $statement ->execute(array('etab' => $etab_zuordn, 'cocktail' => $idNewCock[0] , 'preis' => $preisCock));
			$insertError2 = $statement-> fetch(); 

			if ($insertError == false) {
				$angelegt = true;
				$message = "Erfolgreich angelegt!";
			} else {
				$message = "Ein technsicher Fehler ist aufgetreten.";
			}
		} else {
			$message = 'Dieser Cocktail ist bereits vorhanden. <a class="ct-panel-group" href="cocktail_details.php?cock_id='. $notNewError[0]  .'"> Zum Cocktail </a>';
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
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<title>Cocktail - Neuer Cocktail</title>

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
		<div class="mt-5 ml-5 mr-5">
			<?php
			if ($angemeldet) {
				if ($notNewError or $insertError) {
					echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				} elseif ($angelegt) {
					echo '<div class="alert alert-info col-auto ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				}
				echo '
			<div class="card card-body">
				<h2 class="ml-4">Neuer Cocktail</h2>
				<hr>
				<div class="mr-5 ml-5 mt-2">
					<form action="?newCock=1" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="nameCock">Name</label>
							<input type="text" maxlength="50" class="form-control" id="nameCock" name="nameCock"  placeholder="Cocktail">
						</div>

						<div class="form-group">
							<label for="image">Bild</label>
							<input type="file" name="file" id="image" class="form-control-file"> 	
						</div>

						<div class="form-group">
							<label for="beschreibungCock">Beschreibung</label>
							<input type="text" maxlength="50" class="form-control" id="beschreibungCock" name="beschreibungCock"  placeholder="Beschreibung">
						</div>

						<div class="form-group">
							<label for="preisCock">Preis</label>
							<input type="text" maxlength="50" class="form-control" id="preisCock" name="preisCock"  placeholder="Preis">
						</div>

						<div class="form-group">
							<label for="etab"> Etablissement Zuordnen</label>
							<!--<input type="text" class="form-control" id="etab" placeholder="Nothing" name="wert">-->
							<select class="custom-select" name="etab" id="etab">';
							for($i = 0; $i <count($allEtabsPos); $i++){
								echo '<option value="' . $allEtabsPos[$i][0] .'">'. $allEtabsPos[$i][1] .', ' . $allEtabsPos[$i][2] . '</option>';
							}
							echo '</select>
						</div>

						<button type="submit" class="btn btn-primary">Erstellen</button>
					</form>
				</div>
			</div>';
			} else {
				echo '<div class="card card-body"><h2 class="ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2></div>';
			}
			?>
		</div>
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