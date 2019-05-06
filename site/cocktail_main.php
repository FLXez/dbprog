<?php
include('../php/sessioncheck.php');
$activeHead = "cocktail";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
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
							bc.cocktail_id, 
							CAST(bc.wert AS INTEGER) AS wert
						FROM
							bewertung_cocktail bc
						) sub_bc
					ON
						c.id = sub_bc.cocktail_id
					GROUP BY
						c.id,
						c.name,
						c.beschreibung,
						c.img");
$result = $statement->execute();
$cockFetch = $statement->fetchAll();
$cockCount = count($cockFetch);
?>
<!doctype html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<title>Cocktail - Main</title>

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
				<h2 class="ml-4">Alle Cocktails</h2>
				<hr>
				<div class="row">
					<?php
					for ($i = 0; $i < $cockCount; $i++) {
						echo '
					<div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
						if ($cockFetch[$i][3] == null)
							echo '
						<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '
						<img src="../php/get_img.php?cock_id=' . $cockFetch[$i][0] . '" class="card-img-top">';
						echo '
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h5 class="card-title">' . $cockFetch[$i][1] . '</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<p class="card-text">' . $cockFetch[$i][2] . '</p>
								</div>
							</div>
							<hr>
							<div class="row">							
								<div class="col-4">
									<h5 class="rating-num float-left">' . number_format($cockFetch[$i][4], 1) . '</h5>
								</div>
								<div class="col-8">
									<div class="rating float-right">';
						if ($cockFetch[$i][4] >= 1)			echo '
										<i class="fas fa-star"></i>';
						else								echo '
										<i class="far fa-star"></i>';
						if ($cockFetch[$i][4] >= 1.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($cockFetch[$i][4] >= 1.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else								echo '
										<i class="far fa-star"></i>';
						if ($cockFetch[$i][4] >= 2.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($cockFetch[$i][4] >= 2.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else								echo '
										<i class="far fa-star"></i>';
						if ($cockFetch[$i][4] >= 3.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($cockFetch[$i][4] >= 3.25)	echo '
										<i class="fas fa-star-half-alt"></i>';
						else								echo '
										<i class="far fa-star"></i>';
						if ($cockFetch[$i][4] >= 4.75)		echo '
										<i class="fas fa-star"></i>';
						elseif ($cockFetch[$i][4] >= 4.25)	echo '
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
									<a href="./cocktail_details.php?cock_id=' . $cockFetch[$i][0] . '" class="btn btn-primary btn-block">Details</a>
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