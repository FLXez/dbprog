<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
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
							be.eta_id, 
							CAST(be.wert AS INTEGER) AS wert
						FROM
							bewertung_etablissement be
						) sub_be
					ON
						e.id = sub_be.eta_id
					GROUP BY
						e.id,
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						e.img");
$result = $statement->execute();
$etaFetch = $statement->fetchAll();
$etaCount = count($etaFetch);
?>
<!doctype html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<title>Etablissement - Main</title>

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
		<main role="main">
			<div class="mt-5 ml-5 mr-5">
				<div class="card card-body">
					<h2 class="ml-4">Etablissements</h2>
					<hr>
					<div class="row">
						<?php
						for ($i = 0; $i < $etaCount; $i++) {
							echo '<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
							if ($etaFetch[$i][6] == null)
								echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
							else
								echo '<img src="../php/get_img.php?eta_id=' . $etaFetch[$i][0] . '" class="card-img-top">';
							echo '<div class="card-body">
							<div class="row">
								<div class="col">
									<h5 class="card-title">' . $etaFetch[$i][1] . '</h5>
								</div>
								<div class="col">';

							if ($etaFetch[$i][4] == 1) {
								echo '<img src="../res/verifiziert.png" height="32px" width="32px">';
							}

							echo			'</div>
								<div class="w-100"></div>
								<div class="col">
									<p class="card-text">' . $etaFetch[$i][2] . '<br>' . $etaFetch[$i][3] . '<br></p>
								</div>
								<div class="w-100"></div>
								<div class="col">
									<a href="./etablissement_details.php?eta_id=' . $etaFetch[$i][0] . '" class="btn btn-primary">Details</a>
								</div>
								<div class="col">
									<h5 class="rating-num">' . number_format($etaFetch[$i][5], 1) . '</h5>
									<div class="rating">';

							if ($etaFetch[$i][5] >= 1)				echo '<i class="fas fa-star"></i>';
							else								echo '<i class="far fa-star"></i>';
							if ($etaFetch[$i][5] >= 1.75)			echo '<i class="fas fa-star"></i>';
							elseif ($etaFetch[$i][5] >= 1.25)	echo '<i class="fas fa-star-half-alt"></i>';
							else								echo '<i class="far fa-star"></i>';
							if ($etaFetch[$i][5] >= 2.75)			echo '<i class="fas fa-star"></i>';
							elseif ($etaFetch[$i][5] >= 2.25)	echo '<i class="fas fa-star-half-alt"></i>';
							else								echo '<i class="far fa-star"></i>';
							if ($etaFetch[$i][5] >= 3.75)			echo '<i class="fas fa-star"></i>';
							elseif ($etaFetch[$i][5] >= 3.25)	echo '<i class="fas fa-star-half-alt"></i>';
							else								echo '<i class="far fa-star"></i>';
							if ($etaFetch[$i][5] >= 4.75)			echo '<i class="fas fa-star"></i>';
							elseif ($etaFetch[$i][5] >= 4.25)	echo '<i class="fas fa-star-half-alt"></i>';
							else								echo '<i class="far fa-star"></i>';


							echo			'</div>
								</div>
							</div>
						</div>
					</div>';
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