<?php
include('../php/sessioncheck.php');
$activeHead = "cocktail";
$_SESSION['source']= "Location: ../site/cocktail_details.php";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');


$statement = $pdo->prepare("
					SELECT 
						c.id,
						c.name,
						c.beschreibung,
						c.img
					FROM cocktail c
					WHERE c.id = :cock_id");
$result = $statement->execute(array('cock_id' => $_GET['cock_id']));
$cockFetch = $statement->fetch();

$bew = false;
$bew_success = false;
$bew_error = false;
$message = 'If Abfrage wurde nicht betreten!';
if (isset($_GET['bewertung_abgeben']) && $angemeldet) 
{
	$bew = true;

	$statement = $pdo->prepare("SELECT id FROM user WHERE username=:username");
	$result = $statement->execute(array('username'=>$username));
	$userFetch = $statement->fetch();

	$user_id = $userFetch[0];
	$bew_eta = $_POST['eta'];
	$bew_wert = $_POST['wert'];
	$bew_kommentar = $_POST['kommentar'];

	if (!($bew_wert == '1' || $bew_wert == '2' || $bew_wert == '3' || $bew_wert == '4' || $bew_wert == '5'))
	{
		$bew_error = true;
		$message = 'Ungültiger Wert eingetragen!';
		$message = $bew_eta;
	}

	if ($bew_error == false)
	{
		$statement = $pdo->prepare("SELECT * FROM bewertung_cocktail WHERE user_id=:user_id AND eta_id=:eta_id AND cocktail_id=:cock_id");
		$result = $statement->execute(array('user_id' => $user_id, 'eta_id'=>$bew_eta, 'cock_id'=>$_GET['cock_id']));
		$bew_vorhanden = $statement->fetch();

		if ($bew_vorhanden == true) {
			$statement = $pdo->prepare("UPDATE bewertung_cocktail SET wert=:wert, text=:kommentar WHERE user_id=:user_id AND eta_id=:eta_id AND cocktail_id=:cock_id");
			$result = $statement->execute(array('wert'=>$bew_wert, 'kommentar'=>$bew_kommentar, 'user_id' => $user_id, 'eta_id'=>$bew_eta, 'cock_id'=>$_GET['cock_id']));
			$bew_success = $statement->fetch();
		} else {
			$statement = $pdo->prepare("INSERT INTO bewertung_cocktail (user_id, eta_id, cocktail_id, wert, text) VALUES (:user_id, :eta_id, :cock_id, :wert, :kommentar)");
			$result = $statement->execute(array('wert'=>$bew_wert, 'kommentar'=>$bew_kommentar, 'user_id' => $user_id, 'eta_id'=>$bew_eta, 'cock_id'=>$_GET['cock_id']));
			$bew_success = $statement->fetch();
		}
	}
}

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
$result = $statement->execute(array('cock_id' => $_GET['cock_id']));
$etaFetch = $statement->fetchAll();

$statement = $pdo->prepare("
					SELECT
						u.username,
						bc.text,
						bc.wert,
						bc.timestamp,
						e.name
					FROM bewertung_cocktail bc
					JOIN user u ON
						bc.user_id = u.id
					JOIN etablissement e ON
						bc.eta_id = e.id
					WHERE bc.cocktail_id = :cock_id
					ORDER BY e.name");
$result = $statement->execute(array('cock_id' => $_GET['cock_id']));
$bewFetch = $statement->fetchAll();

$statement = $pdo->prepare("
					SELECT 
						e.id, 
						e.name, 
						e.ort 
					FROM etablissement e
					JOIN cocktailkarte ck ON
						e.id = ck.eta_id
					WHERE ck.cocktail_id = :cock_id");
$result = $statement->execute(array('cock_id'=>$_GET['cock_id']));
$allEtaFetch = $statement->fetchAll();
?>
<!doctype html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
	<link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
	<title>Cocktail - Details</title>

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
                    echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
                    echo $message;
                    echo '</div>';
                }
			?>
			<div class="card mb-3" width="100%" style="max-height: 360px;">
				<div class="row no-gutters">
					<div class="col-md-2">
						<?php
						if ($cockFetch[3] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
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
			<div class="card card-body">
				<ul class="nav nav-pills flex-column flex-sm-row" id="cockDetail-tab" role="tablist">
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
				<div class="tab-content" id="cockDetail-tabContent">
					<div class="tab-pane fade show active" id="cocktailKarte" role="tabpanel" aria-labelledby="cocktailKarte-tab">
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
					<div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertungen-tab">
						<?php echo '
						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nutzername</th>
									<th scope="col">Etablissement</th>
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
							echo '<td>' . $bewFetch[$i][4] . '</td>';
							echo '<td>' . $bewFetch[$i][1] . '</td>';
							echo '<td>' . $bewFetch[$i][2] . '</td>';
							echo '<td>' . $bewFetch[$i][3] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<div class="tab-pane fade" id="bewerten" role="tabpanel" aria-labelledby="bewerten-tab">
						<?php
						if($angemeldet)
						{
							if($bew_success == false)
							{
								echo '
								<form class="mr-5 ml-5 mt-2" action="?cock_id=' . $_GET['cock_id'] . '&bewertung_abgeben=1" method="post">
									<div class="form-group">
										<label for="eta">Wo getrunken?</label>
										<!--<input type="text" class="form-control" id="bew_eta" placeholder="Etablissement ausw&auml;hlen" name="eta">-->
										<select class="custom-select" name="eta" id="bew_eta">';
										for ($i = 0; $i < count($allEtaFetch); $i++)
										{
											echo '<option value="' . $allEtaFetch[$i][0] . '">' . $allEtaFetch[$i][1] . ', ' . $allEtaFetch[$i][2] . '</option>';
										}
								echo	'</select>
									</div>
									<div class="form-group">
										<label for="wert">Wie war er?</label>
										<input type="text" class="form-control" id="bew_wert" placeholder="0 Sterne" name="wert">
									</div>
									<div class="form-group">
										<label for="kommentar">Kommentar!</label>
										<textarea class="form-control" id="bew_kommentar" aria-label="Beispieltext" name="kommentar"></textarea>
									</div>
									<button type="submit" class="btn btn-primary mt-2">Bewertung abschicken!</button>
								</form>';
							}
							else 
							{
								echo '<h2 class="ml-4 ct-text-center">Bewertung erfolgreich abgegeben!</h2>';
							}
						}
						else 
						{
							echo '<h2 class="ml-4 ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2>';
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