<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
					SELECT 
						e.id,
						e.name,
						e.anschrift,
						e.ort,
						e.img
					FROM etablissement e
					WHERE e.id = :eta_id");
$result = $statement->execute(array('eta_id'=>$_GET['eta_id']));
$etaFetch = $statement->fetch();

$statement = $pdo->prepare("
					SELECT
						c.id,
						c.name,
						ck.preis
					FROM cocktailkarte ck
					JOIN cocktail c ON
						c.id = ck.cocktail_id
					WHERE ck.eta_id = :eta_id");
$result = $statement->execute(array('eta_id'=>$_GET['eta_id']));
$cockFetch = $statement->fetchAll();

$statement = $pdo->prepare("
					SELECT
						u.username,
						be.text,
						be.wert,
						be.timestamp
					FROM bewertung_etablissement be
					JOIN user u ON
						be.user_id = u.id
					WHERE be.eta_id = :eta_id");
$result = $statement->execute(array('eta_id'=>$_GET['eta_id']));
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
						if ($etaFetch[4] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else 
							echo '<img src="../php/get_img.php?eta_id=' . $etaFetch[$i][0] . '" class="card-img-top">';
						?>
					</div>
					<div class="col-md-8">
						<div class="card-body">
							<h5 class="card-title"> <?php echo $etaFetch[1]; ?> </h5>
							<p class="card-text"> <?php echo $etaFetch[2] . '<br>' . $etaFetch[3]; ?> </p>
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
									<th scope="col">Cocktail</th>
									<th scope="col">Preis</th>
								</tr>
							</thead> 
							<tbody>';

						for ($i = 0; $i < count($cockFetch); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td>' . $cockFetch[$i][1] . '</td>';
							echo '<td>' . $cockFetch[$i][2] . '</td>';
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