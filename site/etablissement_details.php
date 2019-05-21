<?php
session_start();
$activeHead = "etablissement";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

$etabId = $_GET['etab_id'];
if (isset($_SESSION['userId'])) {

	$userId = $_SESSION['userId'];

	include('../php/db/select_userInfo.php');
}

include('../php/db/select_etabInfo.php');
$bew = false;
$bew_success = false;

if (isset($_GET['bew_abgeben']) && isset($_SESSION['userId'])) {
	$bew = true;
	$bew_wert = $_POST['wert'];
	$bew_kommentar = $_POST['kommentar'];

	include('../php/db/check_bewEtab.php');

	if ($bew_vorhanden) {
		include('../php/db/update_bewEtab.php');
		if ($result) {
			$message = 'Ihre Bewertung wurde aktualisiert!';
		} else {
			$message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
		}
	} else {
		include('../php/db/insert_bewEtab.php');
		if ($result) {
			$message = 'Ihre Bewertung wurde gespeichert!';
		} else {
			$message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
		}
	}
}

include('../php/db/select_etab_bew.php');
//cocktailkarte
include('../php/db/select_cocktailkarte.php');

//falls verifiziert wird, vars schon mal festlegen
$_SESSION['verify'] = $etabInfo["verifiziert"];
$_SESSION['etabid'] = $etabId;

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
			include('../php/alertMessage.php');
			?>

			<div class="card mb-3" width="100%" style="max-height: 360px;">

				<div class="row no-gutters">
					<div class="col-md-2">
						<?php
						if ($etabInfo["img"] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '<img src="../php/db/get_img.php?etab_id=' . $etabInfo["id"] . '" class="card-img-top">';
						?>
					</div>

					<div class="col-md-10">

						<div class="card-body d-flex flex-column" style="max-height: 200px;">
							<div>
								<h1 class="card-title"> <?php echo $etabInfo["name"];
														if ($etabInfo["verifiziert"] == 1) {
															echo '
															<span class="badge badge-primary float-right">Verifiziert</span>';
														} else {
															echo '
															<span class="badge badge-warning float-right">Nicht verifiziert</span>';
														} ?>
								</h1>
								<hr>
							</div>
							<div>
								<p class="card-text"> <?php echo $etabInfo["ort"] . '<br>' . $etabInfo["anschrift"]; ?> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			if (isset($_SESSION['userId']) && $userInfo['admin'] > 0) {
				if ($userInfo['admin'] == 2) {
					$rolle = "Admin";
				} elseif ($userInfo['admin'] == 1) {
					$rolle = "Mod";
				}
				echo '
			<div class="accordion mb-3" id="accordionExample">
				<div class="card border rounded">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">' . $rolle . ' : ' . $userInfo['uname'] . '</button>
						</h2>
					</div>
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<form class="form-inline" action="../php/db/update_etabVerify.php">
								<button class="btn btn-primary mt-2 mr-2" type="submit"> Verifizierung ändern</button>
							</form>
						</div>
					</div>
				</div>
			</div>';
			}

			?>
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
						for ($i = 0; $i < count($cocktailkarte); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $cocktailkarte[$i]["id"] . '">' . $cocktailkarte[$i]["name"] . '</a></td>';
							echo '<td>' . $cocktailkarte[$i]["preis"] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertungen-tab">
						<?php
						if (isset($_SESSION['userId'])) {
							if ($_SESSION['admin'] == 2) {
								echo '
								<table class="table">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Zeitpunkt</th>
											<th scope="col">Nutzername</th>
											<th scope="col">Wert</th>
											<th scope="col">Bewertung</th>
										</tr>
									</thead> 
									<tbody>';
								for ($i = 0; $i < count($etab_bew); $i++) {								
									echo '<tr>';
									echo '<th scope="col"><a href="../php/del_bew.php?bew_id='.$etab_bew[$i]["bew_id"].'&bew=etab"><i class="fas fa-trash"></i></a></th>';
									echo '<td>' . $etab_bew[$i]["ts"] . '</td>';
									echo '<td><a href="../site/profil_other.php?showUser=' . $etab_bew[$i]["userId"] . '">' . $etab_bew[$i]["username"] . '</a></td>';
									echo '<td>' . $etab_bew[$i]["wert"] . '</td>';
									echo '<td>' . $etab_bew[$i]["text"] . '</td>';
									echo '</tr>';
								}
								echo '</tbody></table>';
							} elseif ($_SESSION['admin'] == 1) {
								echo '
								<table class="table">
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Zeitpunkt</th>
											<th scope="col">Nutzername</th>
											<th scope="col">Wert</th>
											<th scope="col">Bewertung</th>
										</tr>
									</thead> 
									<tbody>';
								for ($i = 0; $i < count($etab_bew); $i++) {
									echo '<tr>';
									echo '<th scope="col"><a href=""><i class="fas fa-exclamation-triangle"></i></a></th>';
									echo '<td>' . $etab_bew[$i]["ts"] . '</td>';
									echo '<td><a href="../site/profil_other.php?showUser=' . $etab_bew[$i]["userId"] . '">' . $etab_bew[$i]["username"] . '</a></td>';
									echo '<td>' . $etab_bew[$i]["wert"] . '</td>';
									echo '<td>' . $etab_bew[$i]["text"] . '</td>';
									echo '</tr>';
								}
								echo '</tbody></table>';
							} else {
								echo '
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Zeitpunkt</th>
											<th scope="col">Nutzername</th>
											<th scope="col">Wert</th>
											<th scope="col">Bewertung</th>
										</tr>
									</thead> 
									<tbody>';
								for ($i = 0; $i < count($etab_bew); $i++) {
									echo '<tr>';
									echo '<td>' . $etab_bew[$i]["ts"] . '</td>';
									echo '<td><a href="../site/profil_other.php?showUser=' . $etab_bew[$i]["userId"] . '">' . $etab_bew[$i]["username"] . '</a></td>';
									echo '<td>' . $etab_bew[$i]["wert"] . '</td>';
									echo '<td>' . $etab_bew[$i]["text"] . '</td>';
									echo '</tr>';
								}
								echo '</tbody></table>';
							}
						} else {
							echo '
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Zeitpunkt</th>
										<th scope="col">Nutzername</th>
										<th scope="col">Wert</th>
										<th scope="col">Bewertung</th>
									</tr>
								</thead> 
								<tbody>';
							for ($i = 0; $i < count($etab_bew); $i++) {
								echo '<tr>';
								echo '<td>' . $etab_bew[$i]["ts"] . '</td>';
								echo '<td><a href="../site/profil_other.php?showUser=' . $etab_bew[$i]["userId"] . '">' . $etab_bew[$i]["username"] . '</a></td>';
								echo '<td>' . $etab_bew[$i]["wert"] . '</td>';
								echo '<td>' . $etab_bew[$i]["text"] . '</td>';
								echo '</tr>';
							}
							echo '</tbody></table>';
						}
						?>
					</div>
					<div class="tab-pane fade" id="bewerten" role="tabpanel" aria-labelledby="bewerten-tab">
						<?php
						if (isset($_SESSION['userId'])) {
							if ($bew_success == false) {
								echo '
								<form class="mr-2 ml-2 mt-2" action="?etab_id=' . $_GET['etab_id'] . '&bew_abgeben=1" method="post">
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