<?php
session_start();
$activeHead = "search";
$_SESSION['source'] = "../site/suche.php";
include('../php/buildCard.php');

if (isset($_GET['for'])) {
	$filter = '%' . $_GET['for'] . '%';

	if (isset($_GET['cock'])) {
		$getCock = true;
	} else {
		$getCock = false;
	}

	if (isset($_GET['etab'])) {
		$getEtab = true;
	} else {
		$getEtab = false;
	}

	include('../php/db/select_card_info.php');

	if ($getCock && $getEtab) {
		if (count($cardCock) == 0 && count($cardEtab) == 0) {
			$done = true;
			$error = true;
			$message = "Keine Treffer.";
		} else {
			$done = true;
			$message = "Suchergebnisse werden unten angezeigt!";
		}
	} elseif ($getCock) {
		if (count($cardCock) == 0) {
			$done = true;
			$error = true;
			$message = "Keine Treffer.";
		} else {
			$done = true;
			$message = "Suchergebnisse werden unten angezeigt!";
		}
	} elseif ($getEtab) {
		if (count($cardEtab) == 0) {
			$done = true;
			$error = true;
			$message = "Keine Treffer.";
		} else {
			$done = true;
			$message = "Suchergebnisse werden unten angezeigt!";
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
	<title>Hameln E&C - Suche</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- FontAwesome (icons) -->
	<script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
	<!-- CSS Toolbox -->
	<link href="../css/csstoolbox.css" rel="stylesheet">
</head>

<body>
	<header role="header">
		<?php
		include('../php/buildHeader.php');
		?>
	</header>
	<main role="main">
		<div class="mt-5 ml-5 mr-5">
			<?php
			if (isset($message)) {
				if (isset($error)) {
					echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
					echo $message;
					echo '</div>';
				} else {
					echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
					echo $message;
					echo '</div>';
				}
			}
			?>
			<div class="card card-body">
				<h2 class="ml-2">Suche</h2>
				<hr>
				<form class="ml-2" action="?for=<?php echo $_GET['for'] ?>" method="GET">
					<h5>Suchergebnisse filtern:</h5>
					<div class="form-check form-check-inline mb-3">
						<input class="form-check-input" type="checkbox" id="cock" name="cock[]" value="true" <?php if (isset($getCock)) {
																													if ($getCock) {
																														echo 'checked';
																													} else {
																														echo '';
																													}
																												} else {
																													echo 'checked';
																												} ?>>
						<label class="form-check-label" for="cock">Cocktails anzeigen</label>
					</div>
					<div class="form-check form-check-inline mb-3">
						<input class="form-check-input" type="checkbox" id="etab" name="etab[]" value="true" <?php if (isset($getEtab)) {
																													if ($getEtab) {
																														echo 'checked';
																													} else {
																														echo '';
																													}
																												} else {
																													echo 'checked';
																												} ?>>
						<label class="form-check-label" for="etab">Etablissements anzeigen</label>
					</div>
					<input type="text" maxlength="50" size="50" class="form-control" id="search" name="for" placeholder="Was suchst du?" value="<?php if (isset($_GET['for'])) {
																																					echo $_GET['for'];
																																				} ?>" required>
					<button type="submit" class="btn btn-primary mt-3">Suchen</button>
				</form>
			</div>
			<?php
			if (isset($done) && !isset($error)) {
				if ($getEtab) {
					echo '
			<div class="card card-body mt-3">
				<h2 class="ml-2">Gefundene Etablissements:</h2>
				<hr>
				<div class="row">';
					for ($i = 0; $i < count($cardEtab); $i++) {
						buildCard_etab($cardEtab[$i][0], $cardEtab[$i][1], $cardEtab[$i][2], $cardEtab[$i][3], $cardEtab[$i][4], $cardEtab[$i][5], $cardEtab[$i][6], $cardEtab[$i][7]);
					}
					echo '
				</div>
			</div>';
				}
				if ($getCock) {
					echo '
			<div class="card card-body mt-3">
				<h2 class="ml-2">Gefundene Cocktails:</h2>
				<hr>
				<div class="row">';
					for ($i = 0; $i < count($cardCock); $i++) {
						buildCard_cock($cardCock[$i][0], $cardCock[$i][1], $cardCock[$i][2], $cardCock[$i][3], $cardCock[$i][4], $cardCock[$i][5]);
					}
					echo '
				</div>
			</div>';
				}
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