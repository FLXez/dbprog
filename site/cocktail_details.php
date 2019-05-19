<?php
session_start();
$activeHead = "cocktail";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

$cockId = $_GET['cock_id'];
if (isset($_SESSION['userId'])) {

	$userId = $_SESSION['userId'];

	include('../php/db/select_userInfo.php');
}

include('../php/db/select_cockInfo.php');

$bew = false;
$bew_success = false;
$message = 'Fehler';

if (isset($_GET['etab_zuordnen'])) {

	$etabId = $_POST['etab_zugeordnet'];
	$preis = $_POST['preis_cock'];
	include('../php/db/insert_cockEtab.php');

	if ($result) {
		$message = "Erfolgreich hinzugefügt.";
	} else {
		$message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
	}
}

if (isset($_GET['bew_abgeben']) && isset($_SESSION['userId'])) {
	$userId = $_SESSION['userId'];
	$bew = true;
	$etabId = $_POST['eta'];
	$bew_wert = $_POST['wert'];
	$bew_kommentar = $_POST['kommentar'];

	include('../php/db/check_bewCock.php');

	if ($bew_vorhanden) {
		include('../php/db/select_cock_etab_id.php');
		include('../php/db/update_bewCock.php');
		if ($result) {
			$message = 'Ihre Bewertung wurde aktualisiert!';
		} else {
			$message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
		}
	} else {
		include('../php/db/select_cock_etab_id.php');
		include('../php/db/insert_bewCock.php');
		if ($result) {
			$message = 'Ihre Bewertung wurde gespeichert!';
		} else {
			$message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
		}
	}
}

//Cocktailkarte
include('../php/db/select_cocktailkarte.php');

include('../php/db/select_cock_bew.php');

include('../php/db/select_cockEtab_liste.php');

//Funktion etab zuordnen
include('../php/db/select_allEtab.php');
include('../php/db/select_cockEtab_id.php');

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
				echo '<div class="alert alert-info ct-text-center mb-4" role="info">';
				echo $message;
				echo '</div>';
			}
			?>
			<div class="card mb-3" width="100%" style="max-height: 360px;">
			<?php
				if (isset($_SESSION['userId']) && $userInfo['admin'] > 0) {
					if ($userInfo['admin'] == 2) {
						$rolle = "Admin";
					} elseif ($userInfo['admin'] == 1) {
						$rolle = "Mod";
					}
					echo '
					<div class="accordion" id="accordionExample">
  <div class="card border">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
		' . $rolle . ' : '. $userInfo['uname'].'
        </button>
      </h2>
	</div>
	<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        Hier dann so krams zum bearbeiten so tools diesen so
      </div>
    </div>
  </div>
  </div>';
				}

				?>
				<div class="row no-gutters">
					<div class="col-md-2">
						<?php
						if ($cockInfo["img"] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '<img src="../php/db/get_img.php?cock_id=' . $cockInfo["id"] . '" class="card-img-top">';
						?>
					</div>
					<div class="col-md-10">
						<div class="card-body d-flex flex-column" style="height: 230px;">
							<div>
								<h1 class="card-title"> <?php echo $cockInfo["name"]; ?> </h1>
								<hr>
							</div>
							<div>
								<p class="card-text"> <?php echo $cockInfo["beschreibung"]; ?> </p>
							</div>
							<div class="mt-auto">
								<?php echo '							 	
								<form action="?cock_id=' . $_GET['cock_id'] . '&etab_zuordnen=1" method="POST">
								<label for="etab_zugeordnet">Cocktail einem Etablissement zuordnen:</label>
									<div class="form-row">
										<div class="col-4">
										<select class="custom-select" name="etab_zugeordnet" id="etab_zugeordnet">';
								for ($i = 0; $i < count($allEtab); $i++) {

									$isValid = true;

									for ($j = 0; $j < count($select_cockEtab_id); $j++) {
										if ($allEtab[$i][0] == $select_cockEtab_id[$j][0]) {
											$isValid = false;
										}
									}

									if ($isValid == true) {
										echo '<option value="' . $allEtab[$i][0] . '">' . $allEtab[$i][1] . ', ' . $allEtab[$i][2] . '</option>';
									}
								}
								echo '
										</select>
										</div>
										<div class="col-4">
										<input type="text" maxlength="10" class="form-control" name="preis_cock" id="preis_cock" placeholder="Preis" required>
										</div>
										<div class="col-auto">
											<button type="submit" class="btn btn-primary">Hinzuf&uuml;gen</button>
										</div>
									</div>
								</form>'; ?>
							</div>
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

						for ($i = 0; $i < count($cocktailkarte); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td>  <a class="" href="etablissement_details.php?etab_id= ' . $cocktailkarte[$i]["id"] . '">' . $cocktailkarte[$i]["name"] . '</a></td>';
							echo '<td>' . $cocktailkarte[$i]["ort"] . '</td>';
							echo '<td>' . $cocktailkarte[$i]["preis"] . '</td>';
							echo '<td>' . $cocktailkarte[$i]["wert"] . '</td>';
							echo '</tr>';
						}
						echo '
							</tbody>
						</table>';
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

						for ($i = 0; $i < count($cock_bew); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td> <a class="" href="../site/profil_other.php?showUser=' . $cock_bew[$i]["userId"] . '">' . $cock_bew[$i]["username"] . '</a></td>';
							echo '<td> <a class="" href="../site/etablissement_details.php?etab_id= ' . $cock_bew[$i]["etab_id"] . '">' . $cock_bew[$i]["etab_name"] . '</a></td>';
							echo '<td>' . $cock_bew[$i]["text"] . '</td>';
							echo '<td>' . $cock_bew[$i]["wert"] . '</td>';
							echo '<td>' . $cock_bew[$i]["ts"] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<div class="tab-pane fade" id="bewerten" role="tabpanel" aria-labelledby="bewerten-tab">
						<?php
						if (isset($_SESSION['userId'])) {
							if ($bew_success == false) {
								echo '
								<form class="mr-2 ml-2 mt-2" action="?cock_id=' . $_GET['cock_id'] . '&bew_abgeben=1" method="post">
									<div class="form-group">
										<label for="eta">Wo getrunken?</label>
										<!--<input type="text" class="form-control" id="bew_etab" placeholder="Etablissement ausw&auml;hlen" name="eta">-->
										<select class="custom-select" name="eta" id="bew_etab">';
								for ($i = 0; $i < count($cockEtab_liste); $i++) {
									echo '<option value="' . $cockEtab_liste[$i]["eid"] . '">' . $cockEtab_liste[$i]["ename"] . ', ' . $cockEtab_liste[$i]["eort"] . '</option>';
								}
								echo	'</select>
									</div>
									<div class="form-group">
										<label for="wert">Wie war er?</label>
										<!--<input type="text" class="form-control" id="bew_wert" placeholder="0 Sterne" name="wert">-->
										<select class="custom-select" name="wert" id="bew_etab">
											<option value="1">★☆☆☆☆</option>
											<option value="2">★★☆☆☆</option>
											<option value="3">★★★☆☆</option>
											<option value="4">★★★★☆</option>
											<option value="5">★★★★★</option>
										</select>
									</div>
									<div class="form-group">
										<label for="kommentar">Kommentar!</label>
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