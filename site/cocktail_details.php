<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
					SELECT 
						c.id,
						c.name,
						c.beschreibung,
						e.img
					FROM cocktail c
					WHERE c.id = :cock_id");
$result = $statement->execute(array('cock_id'=>$_GET['cock_id']));
$cockFetch = $statement->fetch();

$statement = $pdo->prepare("
					SELECT
						e.id,
						e.name,
						e.ort,
						ck.preis,
						AVG(bc.wert),
						ck.cocktail_id
					FROM cocktailkarte ck
					JOIN etablissement e ON
						e.id = ck.eta_id
					LEFT JOIN bewertung_cocktail bc ON
						ck.cocktail_id = bc.cocktail_id AND
						e.id = bc.eta_id
					WHERE ck.cocktail_id = :cock_id
					GROUP BY
						e.id,
						e.name,
						e.ort,
						ck.preis,
						ck.cocktail_id");
$result = $statement->execute(array('cock_id'=>$_GET['cock_id']));
$etaFetch = $statement->fetchAll();

$statement = $pdo->prepare("
					SELECT
						u.username,
						bc.text,
						bc.wert,
						be.timestamp
					FROM bewertung_etablissement be
					JOIN user u ON
						be.user_id = u.id
					WHERE be.eta_id = :eta_id");
$result = $statement->execute(array('eta_id'=>$_GET['cock_id']));
$bewFetch = $statement->fetchAll();
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
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
            <div class="card mb-3" width="100%" style="max-height: 360px;">
				<div class="row no-gutters">
					<div class="col-md-2">
						<?php 
						if ($cockFetch[3] == null)
							echo '<img src="../res/placeholder_cocktail.svg" class="card-img-top">';
						else 
							echo '<img src="../php/get_img.php?cock_id=' . $cockFetch[0] . '" class="card-img-top">';
						?>
					</div>
					<div class="col-md-8">
						<div class="card-body">
							<h5 class="card-title"> <?php echo $cockFetch[1]; ?> </h5>
							<p class="card-text"> <?php echo $cockFetch[2]; ?> </p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="card card-body">
						<h2 class="ml-4">Cocktailkarte</h2>
						<hr>
						<?php echo '
						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Etablissement</th>
									<th scope="col">Ort</th>
									<th scope="col">Preis</th>
									<th scope="col">Durchschnittsbewertung</th>
								</tr>
							</thead> 
							<tbody>';

						for ($i = 0; $i < count($etaFetch); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td>' . $etaFetch[$i][1] . '</td>';
							echo '<td>' . $etaFetch[$i][2] . '</td>';
							echo '<td>' . $etaFetch[$i][3] . '</td>';
							echo '<td>' . $etaFetch[$i][4] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
				</div>
				<div class="col-6">
					<div class="card card-body">
						<h2 class="ml-4">Bewertungen</h2>
						<hr>
						<?php echo '
						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nutzername</th>
									<th scope="col">Bewertung</th>
									<th scope="col">Wert</th>
									<th scope="col">Zeitpunkt</th>
								</tr>
							</thead> 
							<tbody>';

						for ($i = 0; $i < count($bewFetch); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td>' . $bewFetch[$i][0] . '</td>';
							echo '<td>' . $bewFetch[$i][1] . '</td>';
							echo '<td>' . $bewFetch[$i][2] . '</td>';
							echo '<td>' . $bewFetch[$i][3] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
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