<?php
session_start();
$activeHead = "etablissement";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];


if (isset($_SESSION['userId'])) {
	$error = false;
	$info = false;
	$success = false;
	$message = "";

	if (isset($_GET['newEtab'])) {

		$name = $_POST['nameEtab'];
		$strasse = $_POST['strasseEtab'];
		$stadt = $_POST['plzStadtEtab'];


		$file_name = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		$file_size = $_FILES['file']['size'];
		$file_tem_loc = $_FILES['file']['tmp_name'];

		if ($file_name) {
			$handle = fopen($file_tem_loc, 'r');
			$image = fread($handle, $file_size);
		} else {
			$image = "";
		}

		include('../php/db/check_etab.php');
		if (!$etab_vorhanden) {
			include('../php/db/insert_etab.php');
			if ($result) {
				$message = "Erfolgreich angelegt!";
				$success = true;
			} else {
				$message = "Ein technsicher Fehler ist aufgetreten.";
				$error = true;
			}
		} else {
			$message = "Dieses Etablissement ist bereits vorhanden.";
			$info = true;
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
		<div class="mt-5 ml-5 mr-5">
			<?php
			if (isset($_SESSION['userId'])) {
				if ($error) {
					echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				} elseif ($success or $info) {
					echo '<div class="alert alert-info col-auto ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				} ?>
				<div class="card card-body">
					<h2 class="ml-2">Neues Etablissement</h2>
					<hr>
					<div class="mr-2 ml-2 mt-2">
						<form action="?newEtab=1" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label for="nameEtab">Name</label>
								<input type="text" maxlength="50" class="form-control" id="nameEtab" name="nameEtab" placeholder="Etablissement" required>
							</div>
							<div class="form-group">
								<label for="image">Bild</label>
								<input type="file" name="file" id="image" class="form-control-file">
							</div>
							<div class="form-group">
								<label for="adresseEtab">Adresse</label>
								<input type="text" maxlength="50" class="form-control mb-2" id="strasseEtab" name="strasseEtab" placeholder="Stra&szlig;e" required>
								<input type="text" maxlength="50" class="form-control" id="plzStadtEtab" name="plzStadtEtab" placeholder="Postleitzahl Stadt" required>
							</div>
							<button type="submit" class="btn btn-primary">Erstellen</button>
						</form>
					</div>
				</div>
			<?php
		} else {
			echo '<div class="card card-body"><h2 class="ct-text-center">Bitte zuerst <a class="" href="signin.php">Anmelden</a>.</h2></div>';
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