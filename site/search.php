<?php
include('../php/sessioncheck.php');
$activeHead = "search";
$_SESSION['source'] = "Location: ../site/search.php";

$sucheBeendet = "";
$keinErgebnis = "";
$message = "";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

if (isset($_GET['search'])) {
	$suchbegriff ="%". $_POST['search'] ."%";

	$sucheEtab = $pdo->prepare("
					SELECT 
						e.id,
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						AVG(sub_be.wert),
						e.img
					FROM etablissement e
					LEFT JOIN 
						(
						SELECT 
							be.etab_id, 
							CAST(be.wert AS INTEGER) AS wert
						FROM
							bew_etab be
						) sub_be
					ON
						e.id = sub_be.etab_id
					WHERE 
						name LIKE :name
					GROUP BY
						e.id,
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						e.img");
	$resultEtab = $sucheEtab->execute(array('name' => $suchbegriff));
	$ergebnisEtab = $sucheEtab->fetchAll();
	$etabCount = count($ergebnisEtab);


	$sucheCock = $pdo->prepare("
					SELECT 
						c.id,
						c.name,
						c.beschreibung,
						c.img,
						AVG(sub_bc.wert)
					FROM cocktail c
					LEFT JOIN 
						(
						SELECT 
							bc.cock_id, 
							CAST(bc.wert AS INTEGER) AS wert
						FROM
							bew_cock bc
						) sub_bc
					ON
						c.id = sub_bc.cock_id
					WHERE
						name LIKE :name
					GROUP BY
						c.id,
						c.name,
						c.beschreibung,
						c.img");
	$resultCock = $sucheCock->execute(array('name' => $suchbegriff));
	$ergebnisCock = $sucheCock->fetchAll();
	$cockCount = count($ergebnisCock);

	if ($cockCount == 0 && $etabCount == 0) {
		$keinErgebnis = true;
		$message = "Leider nichts gefunden AMK";
	} else {
		$message = "Suche abgeschlossen";
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
				<h2 class="ml-4">Suche</h2>
				<hr>
				<div class="ml-5 mr-5 mt-2">
					<form action="?search=1" method="POST">
						<div class="form group">
							<input type="text" maxlength="50" class="form-control" id="search" name="search" placeholder="Was suchst du?" required>
							<button type="submit" class="btn btn-primary mt-2">Suchen</button>
						</div>
					</form>
				</div>
			</div>
			<div class="card card-body mt-3">
				<h2 class="ml-4">Ergebnisse</h2>
				<hr>
				<div class="ml-5 mr-5 mt-2">
					<?php
					if ($sucheBeendet && $keinErgebnis == false) {
						for ($i = 0; $i < $etabCount; $i++) {
							echo '
							<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
							if ($ergebnisEtab[$i][6] == null)
								echo '
						<img src="../res/placeholder_no_image.svg" class="card-img-top">';
							else
								echo '
						<img src="../php/get_img.php?eta_id=' . $ergebnisEtab[$i][0] . '" class="card-img-top">';
							echo '
						<div class="card-body">
							<div class="row justify-content-between">
								<div class="col-7">
									<h5 class="card-title float-left">' . $ergebnisEtab[$i][1] . '</h5>
								</div>
								<div class="col-5">';
							if ($ergebnisEtab[$i][4] == 1) {
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
									<p class="card-text">' . $ergebnisEtab[$i][2] . '<br>' . $ergebnisEtab[$i][3] . '</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-4">
									<h5 class="rating-num float-left">' . number_format($ergebnisEtab[$i][5], 1) . '</h5>
								</div>
								<div class="col-8">
									<div class="rating float-right">';
							if ($ergebnisEtab[$i][5] >= 1)			echo '
										<i class="fas fa-star"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($ergebnisEtab[$i][5] >= 1.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($ergebnisEtab[$i][5] >= 1.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($ergebnisEtab[$i][5] >= 2.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($ergebnisEtab[$i][5] >= 2.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($ergebnisEtab[$i][5] >= 3.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($ergebnisEtab[$i][5] >= 3.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
							else								echo '
										<i class="far fa-star"></i>';
							if ($ergebnisEtab[$i][5] >= 4.75)		echo '
										<i class="fas fa-star"></i>';
							elseif ($ergebnisEtab[$i][5] >= 4.25)	echo '
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
									<a href="./etablissement_details.php?eta_id=' . $ergebnisEtab[$i][0] . '" class="btn btn-primary btn-block">Details</a>
								</div>
							</div>							
						</div>
					</div>';
						}


						for ($i = 0; $i < $cockCount; $i++) {
							echo '
								<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
											if ($ergebnisCock[$i][3] == null)
												echo '
												<img src="../res/placeholder_no_image.svg" class="card-img-top">';
											else
												echo '
												<img src="../php/get_img.php?cock_id=' . $ergebnisCock[$i][0] . '" class="card-img-top">';
												echo '
									<div class="card-body">
										<div class="row">
											<div class="col-12">
												<h5 class="card-title">' . $ergebnisCock[$i][1] . '</h5>
											</div>
										</div>
											<div class="row">
												<div class="col-12">
													<p class="card-text">' . $ergebnisCock[$i][2] . '</p>
												</div>
											</div>
											<hr>
											<div class="row">							
												<div class="col-4">
														<h5 class="rating-num float-left">' . number_format($ergebnisCock[$i][4], 1) . '</h5>
												</div>
												<div class="col-8">
													<div class="rating float-right">';
																if ($ergebnisCock[$i][4] >= 1)			echo '
																	<i class="fas fa-star"></i>';
																else								echo '
																	<i class="far fa-star"></i>';
																if ($ergebnisCock[$i][4] >= 1.75)		echo '
																	<i class="fas fa-star"></i>';
																elseif ($ergebnisCock[$i][4] >= 1.25)	echo '
																	<i class="fas fa-star-half-alt"></i>';
																else								echo '
																	<i class="far fa-star"></i>';
																if ($ergebnisCock[$i][4] >= 2.75)		echo '
																	<i class="fas fa-star"></i>';
																elseif ($ergebnisCock[$i][4] >= 2.25)	echo '
																	<i class="fas fa-star-half-alt"></i>';
																else								echo '
																	<i class="far fa-star"></i>';
																if ($ergebnisCock[$i][4] >= 3.75)		echo '
																	<i class="fas fa-star"></i>';
																elseif ($ergebnisCock[$i][4] >= 3.25)	echo '
																	<i class="fas fa-star-half-alt"></i>';
																else								echo '
																	<i class="far fa-star"></i>';
																if ($ergebnisCock[$i][4] >= 4.75)		echo '
																	<i class="fas fa-star"></i>';
																elseif ($ergebnisCock[$i][4] >= 4.25)	echo '
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
																<a href="./cocktail_details.php?cock_id=' . $ergebnisCock[$i][0] . '" class="btn btn-primary btn-block">Details</a>
											</div>
										</div>
									</div>
							</div>';
						}
						} else {
							echo 'Keine Ergebnisse.';
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