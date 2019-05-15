<?php
include('../php/sessioncheck.php');
$activeHead = "search";
$_SESSION['source'] = "Location: ../site/search.php";

$sucheBeendet = false;
$keinErgebnis = false;
$message = "";

if (isset($_GET['search'])) {
	$filter = "%" . $_POST['search'] . "%";
	$getEtab = true;
	$getCock = true;
	include('../php/db/select_card_info.php');

	if (count($cardCock) == 0 && count($cardEtab) == 0) {
		$keinErgebnis = true;
		$message = "Keine Übereinstimmungen.";
	} else {
		$message = "Suchergebnisse werden unten angezeigt!";
	}
	$sucheBeendet = true;
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

			if ($keinErgebnis) {
				echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
				echo $message;
				echo '</div>';
			} elseif ($sucheBeendet) {
				echo '<div class="alert alert-info col-auto ct-text-center mb-4" role="alert">';
				echo $message;
				echo '</div>';
			}
			?>
			<div class="card card-body">
				<h2 class="ml-2">Suche</h2>
				<hr>
				<form class="ml-2" action="?search=1" method="POST">
					<div class="form group">
						<input type="text" maxlength="50" class="form-control" id="search" name="search" placeholder="Was suchst du?" required>
						<button type="submit" class="btn btn-primary mt-2">Suchen</button>
					</div>
				</form>
			</div>
			<div class="card card-body mt-3">
				<h2 class="ml-2">Ergebnisse</h2>
				<hr>
				<div class="row">
					<?php
					if ($sucheBeendet && $keinErgebnis == false) {
						for ($i = 0; $i < count($cardEtab); $i++) {
							echo '
					<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
							if ($cardEtab[$i][6] == null)
								echo '
					<img src="../res/placeholder_no_image.svg" class="card-img-top">';
							else
								echo '
					<img src="../php/get_img.php?etab_id=' . $cardEtab[$i][0] . '" class="card-img-top">';
							echo '
						<div class="card-body">
							<div class="row justify-content-between">
								<div class="col-7">
									<h5 class="card-title float-left">' . $cardEtab[$i][1] . '</h5>
								</div>
								<div class="col-5">';
							if ($cardEtab[$i][4] == 1) {
								echo '
									<span class="badge badge-primary float-right">Verifiziert</span>';
							} else {
								echo '
									<span class="badge badge-warning float-right">Nicht verifiziert</span>';
							}
							echo '
								</div>
							</div>
							<div class="row">
								<div class="col-12">	
									<p class="card-text">' . $cardEtab[$i][2] . '<br>' . $cardEtab[$i][3] . '</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-4">
									<h5 class="rating-num float-left">' . number_format($cardEtab[$i][5], 1) . '</h5>
								</div>
								<div class="col-8">
									<div class="rating float-right">';
							if ($cardEtab[$i][5] >= 1)			echo '
										<i class="fas fa-star"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardEtab[$i][5] >= 1.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardEtab[$i][5] >= 1.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardEtab[$i][5] >= 2.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardEtab[$i][5] >= 2.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardEtab[$i][5] >= 3.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardEtab[$i][5] >= 3.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardEtab[$i][5] >= 4.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardEtab[$i][5] >= 4.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							echo '
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<a href="./etablissement_details.php?etab_id=' . $cardEtab[$i][0] . '" class="btn btn-primary btn-block">Details</a>
								</div>
							</div>							
						</div>
					</div>';
						}
						for ($i = 0; $i < count($cardCock); $i++) {
							echo '
					<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
							if ($cardCock[$i][3] == null)
								echo '
						<img src="../res/placeholder_no_image.svg" class="card-img-top">';
							else
								echo '
						<img src="../php/get_img.php?cock_id=' . $cardCock[$i][0] . '" class="card-img-top">';
							echo '
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h5 class="card-title">' . $cardCock[$i][1] . '</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<p class="card-text">' . $cardCock[$i][2] . '</p>
								</div>
							</div>
							<hr>
							<div class="row">							
								<div class="col-4">
									<h5 class="rating-num float-left">' . number_format($cardCock[$i][4], 1) . '</h5>
								</div>
								<div class="col-8">
									<div class="rating float-right">';
							if ($cardCock[$i][4] >= 1)			echo '
										<i class="fas fa-star"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardCock[$i][4] >= 1.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardCock[$i][4] >= 1.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardCock[$i][4] >= 2.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardCock[$i][4] >= 2.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardCock[$i][4] >= 3.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardCock[$i][4] >= 3.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($cardCock[$i][4] >= 4.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($cardCock[$i][4] >= 4.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							echo '
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<a href="./cocktail_details.php?cock_id=' . $cardCock[$i][0] . '" class="btn btn-primary btn-block">Details</a>
								</div>
							</div>
						</div>
					</div>';
						}
					} else {
						echo '<div class="ml-4">Keine Ergebnisse.</div>';
					}
					?>

				</div>
			</div>
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