<?php
session_start();
$activeHead = "cocktail";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['userId'])) {
	$error = false;
	$info = false;
	$success = false;
	$message = "";

	include('../php/db/select_allEtab.php');

	if (isset($_GET['newCock'])) {

		$cockName = $_POST['cockName'];
		$cockDesc = $_POST['cockDesc'];
		$etabId = $_POST['etab'];
		$preis = $_POST['preis'];

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

		include('../php/db/check_cock.php');

		if (!$cock_vorhanden) {
			include('../php/db/insert_cock.php');
			include('../php/db/select_cock_id.php');
			$message = 'Cocktail erfolgreich hinzugef&uuml;gt. <a class="" href="cocktail_details.php?cock_id=' . $select_cock_id[0]  . '">(zum Cocktail)</a><br>';
		} else {
			include('../php/db/select_cock_id.php');
			$info = true;
			$message = 'Dieser Cocktail ist bereits vorhanden. <a class="" href="cocktail_details.php?cock_id=' . $select_cock_id[0]  . '">(zum Cocktail)</a><br>';
		}

		$cockId = $select_cock_id[0];
		include('../php/db/insert_cockEtab.php');

		if ($result) {
			$success = true;
			$message .= "Cocktail erfolgreich einem Etablissement zugeordnet!";
		} else {
			$error = true;
			$message .= "Ein technsicher Fehler ist aufgetreten.";
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
			include('../php/alertMessage.php');
			if (isset($_SESSION['userId'])) {
				if ($error) {
					echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				} elseif ($success or $info) {
					echo '<div class="alert alert-info col-auto ct-text-center mb-4" role="alert">';
					echo $message;
					echo '</div>';
				}
				?>
				<div class="card card-body">
					<h2 class="ml-2">Neuer Cocktail</h2>
					<hr>
					<div class="mr-2 ml-2 mt-2">
						<form action="?newCock=1" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="cockName">Name</label>
								<input type="text" maxlength="50" class="form-control" id="cockName" name="cockName" placeholder="Cocktail">
							</div>

							<div class="form-group">
								<label for="image">Bild</label>
								<input type="file" name="file" id="image" class="form-control-file">
							</div>

							<div class="form-group">
								<label for="cockDesc">Beschreibung</label>
								<input type="text" maxlength="50" class="form-control" id="cockDesc" name="cockDesc" placeholder="Beschreibung">
							</div>

							<div class="form-group">
								<label for="preis">Preis</label>
								<input type="text" maxlength="50" class="form-control" id="preis" name="preis" placeholder="Preis">
							</div>

							<div class="form-group">
								<label for="etab"> Etablissement Zuordnen</label>
								<!--<input type="text" class="form-control" id="etab" placeholder="Nothing" name="wert">-->
								<select class="custom-select" name="etab" id="etab">';
									<?php
									for ($i = 0; $i < count($allEtab); $i++) {
										echo '
										<option value="' . $allEtab[$i][0] . '">' . $allEtab[$i][1] . ', ' . $allEtab[$i][2] . '</option>';
									}
									?>
								</select>
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