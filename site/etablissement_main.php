<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";
$_SESSION['source'] = "Location: ../site/etablissement_main.php";

include('../php/db/_openConnection.php');
$statement = $pdo->prepare("
					SELECT 
						e.id as id,
						e.name as name,
						e.ort as ort,
						e.anschrift as anschrift,
						e.verifiziert as verifiziert,
						AVG(sub_be.wert) as avgwert,
						e.img
					FROM etab e
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
					GROUP BY
						e.id,
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						e.img");
$result = $statement->execute();
$etabFetch = $statement->fetchAll();
$etaCount = count($etabFetch);
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
		<div class="mt-5 ml-5 mr-5">
			<div class="card card-body">
				<h2 class="ml-2">Etablissements</h2>
				<hr>
				<div class="row">
					<?php
					for ($i = 0; $i < $etaCount; $i++) {
						echo '
					<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
						if ($etabFetch[$i]["img"] == null)
							echo '
						<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '
						<img src="../php/get_img.php?etab_id=' . $etabFetch[$i]["id"] . '" class="card-img-top">';
						echo '
						<div class="card-body">
							<div class="row justify-content-between">
								<div class="col-7">
									<h5 class="card-title float-left">' . $etabFetch[$i]["name"] . '</h5>
								</div>
								<div class="col-5">';
						if ($etabFetch[$i]["verifiziert"] == 1) {
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
									<p class="card-text">' . $etabFetch[$i]["ort"] . '<br>' . $etabFetch[$i]["anschrift"] . '</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-4">
									<h5 class="rating-num float-left">' . number_format($etabFetch[$i]["avgwert"], 1) . '</h5>
								</div>
								<div class="col-8">
									<div class="rating float-right">';
						if ($etabFetch[$i]["avgwert"] >= 1)			echo '
										<i class="fas fa-star"></i>';
						else										echo '
										<i class="far fa-star"></i>';
						if ($etabFetch[$i]["avgwert"] >= 1.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($etabFetch[$i]["avgwert"] >= 1.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else										echo '
										<i class="far fa-star"></i>';
						if ($etabFetch[$i]["avgwert"] >= 2.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($etabFetch[$i]["avgwert"] >= 2.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else										echo '
										<i class="far fa-star"></i>';
						if ($etabFetch[$i]["avgwert"] >= 3.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($etabFetch[$i]["avgwert"] >= 3.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else										echo '
										<i class="far fa-star"></i>';
						if ($etabFetch[$i]["avgwert"] >= 4.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($etabFetch[$i]["avgwert"] >= 4.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else										echo '
										<i class="far fa-star"></i>';
						echo '
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-12">
									<a href="../site/etablissement_details.php?etab_id=' . $etabFetch[$i]["id"] . '" class="btn btn-primary btn-block">Details</a>
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