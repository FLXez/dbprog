<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";
// Musste nach unten geschoben werden = $_SESSION['source']= "Location: ../site/etablissement_details.php?eta_id=" . $etaFetch[0];

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$bew = false;
$bew_success = false;
if (isset($_GET['bewertung_abgeben']) && $angemeldet) {
	$bew = true;
	$bew_wert = $_POST['wert'];
	$bew_kommentar = $_POST['kommentar'];

	$statement = $pdo->prepare("
						SELECT * 
						FROM bewertung_etablissement
						WHERE user_id=:user_id 
						  AND eta_id=:eta_id ");
	$result = $statement->execute(array('user_id' => $_SESSION['userid'], 'eta_id' => $_GET['eta_id']));
	$bew_vorhanden = $statement->fetch();

	if ($bew_vorhanden == true) {
		$statement = $pdo->prepare("
							UPDATE bewertung_etablissement
							SET wert=:wert, 
								text=:kommentar 
							WHERE user_id=:user_id 
							  AND eta_id=:eta_id 
							  ");
		$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $_SESSION['userid'], 'eta_id' => $_GET['eta_id']));
		$bew_success = $statement->fetch();
		$message = 'Ihre Bewertung wurde Aktualisiert!';
	} else {
		$statement = $pdo->prepare("
							INSERT 
							INTO bewertung_etablissement (user_id, eta_id, wert, text) 
							VALUES (:user_id, :eta_id, :wert, :kommentar)");
		$result = $statement->execute(array('wert' => $bew_wert, 'kommentar' => $bew_kommentar, 'user_id' => $_SESSION['userid'], 'eta_id' =>  $_GET['eta_id']));
		$bew_success = $statement->fetch();
		$message = 'Ihre Bewertung wurde gespeichert!';
	}
}


$statement = $pdo->prepare("
					SELECT 
						e.id as id,
						e.name as name,
						e.anschrift as anschrift,
						e.ort as ort,
						e.img as img
					FROM etablissement e
					WHERE e.id = :eta_id");
$result = $statement->execute(array('eta_id' => $_GET['eta_id']));
$etaFetch = $statement->fetch();

//UFF
$_SESSION['source'] = "Location: ../site/etablissement_details.php?eta_id=" . $etaFetch[0];

$statement = $pdo->prepare("
					SELECT
						c.id as id,
						c.name as name,
						ck.preis as preis
					FROM cocktailkarte ck
					JOIN cocktail c ON
						c.id = ck.cocktail_id
					WHERE ck.eta_id = :eta_id");
$result = $statement->execute(array('eta_id' => $_GET['eta_id']));
$cockFetch = $statement->fetchAll();

$statement = $pdo->prepare("
					SELECT
						u.username as username,
						u.id as userid,
						be.text as text,
						be.wert as wert,
						be.timestamp as ts
					FROM bewertung_etablissement be
					JOIN user u ON
						be.user_id = u.id
					WHERE be.eta_id = :eta_id");
$result = $statement->execute(array('eta_id' => $_GET['eta_id']));
$bewFetch = $statement->fetchAll();
?>
<!doctype html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<title>Etablissement - Details</title>

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
		if ($bew == true && $bew_success == false) {
				echo '<div class="alert alert-info ct-text-center mb-4" role="info">';
				echo $message;
				echo '</div>';
			}
			?>
			<div class="card mb-3" width="100%" style="max-height: 360px;">
				<div class="row no-gutters">
					<div class="col-md-2">
						<?php
						if ($etaFetch["img"] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '<img src="../php/get_img.php?eta_id=' . $etaFetch["id"] . '" class="card-img-top">';
						?>
					</div>
					<div class="col-md-10">
						<div class="card-body d-flex flex-column" style="height: 230px;">
							<div>
								<h1 class="card-title"> <?php echo $etaFetch["name"]; ?> </h1>
								<hr>
							</div>
							<div>
								<p class="card-text"> <?php echo $etaFetch["ort"] . '<br>' . $etaFetch["anschrift"]; ?> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-body">
				<ul class="nav nav-pills flex-column flex-sm-row" id="etabDetail-tab" role="tablist">
					<li class="flex-sm-fill text-sm-center nav-item">
						<a class="nav-link active" id="cocktailKarte-tab" data-toggle="pill" href="#cocktailKarte" role="tab" aria-controls="cocktailKarte" aria-selected="true">Cocktailkarte</a>
					</li>
					<li class="flex-sm-fill text-sm-center nav-item">
						<a class="nav-link" id="bewertungen-tab" data-toggle="pill" href="#bewertungen" role="tab" aria-controls="bewertungen" aria-selected="false">Bewertungen</a>
					</li>
					<li class="flex-sm-fill text-sm-center nav-item">
						<a class="nav-link" id="bewerten-tab" data-toggle="pill" href="#bewerten" role="tab" aria-controls="bewerten" aria-selected="false">Bewerten!</a>
					</li>
				</ul>
				<hr>
				<div class="tab-content" id="etabDetail-tabContent">
					<div class="tab-pane fade show active" id="cocktailKarte" role="tabpanel" aria-labelledby="cocktailKarte-tab">
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
							echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $cockFetch[$i]["id"] . '">' . $cockFetch[$i]["name"] . '</a></td>';
							echo '<td>' . $cockFetch[$i]["preis"] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertungen-tab">
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
							echo '<td><a class="" href="../site/profil_other.php?showUser=' . $bewFetch[$i]["userid"] . '">' . $bewFetch[$i]["username"] . '</a></td>';
							echo '<td>' . $bewFetch[$i]["text"] . '</td>';
							echo '<td>' . $bewFetch[$i]["wert"] . '</td>';
							echo '<td>' . $bewFetch[$i]["ts"] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<div class="tab-pane fade" id="bewerten" role="tabpanel" aria-labelledby="bewerten-tab">
						<?php
						if ($angemeldet) {
							if ($bew_success == false) {
								echo '
								<form class="mr-5 ml-5 mt-2" action="?eta_id=' . $_GET['eta_id'] . '&bewertung_abgeben=1" method="post">
									<div class="form-group">
										<label for="wert">Wie bewerten Sie das Etablissement?</label>
										<!--<input type="text" class="form-control" id="bew_wert" placeholder="0 Sterne" name="wert">-->
										<select class="custom-select" name="wert" id="bew_eta">
											<option value="1">★☆☆☆☆</option>
											<option value="2">★★☆☆☆</option>
											<option value="3">★★★☆☆</option>
											<option value="4">★★★★☆</option>
											<option value="5">★★★★★</option>
										</select>
									</div>
									<div class="form-group">
										<label for="kommentar">Wieso haben Sie so bewertet?</label>
										<textarea class="form-control" id="bew_kommentar" aria-label="Beispieltext" name="kommentar"></textarea>
									</div>
									<button type="submit" class="btn btn-primary mt-2">Bewertung abschicken!</button>
								</form>';
							} else {
								echo '<h2 class="ml-4 ct-text-center">Bewertung erfolgreich abgegeben!</h2>';
							}
						} else {
							echo '<h2 class="ml-4 ct-text-center">Bitte zuerst <a class="" href="signin.php">Anmelden</a>.</h2>';
						}
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