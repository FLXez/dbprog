﻿<!-- Diese HTML Seite stellt die Detailansicht eines Etablissements dar -->
<?php
session_start();
$activeHead = "etablissement";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

// Die Etablissement-ID wird übergeben
$etabId = $_GET['etab_id'];

// Die Informationen für das Etablissement werden aus der Datenbank geladen
include('../php/db/select_etabInfo.php');
include('../php/db/select_etab_bew.php');
include('../php/db/select_cocktailkarte.php');
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
			include('../php/alertMessage.php');
			?>
			<div class="card mb-3" width="100%" style="max-height: 360px;">
				<div class="row no-gutters">
					<div class="card col-md-2">
						<?php
						// An dieser Stelle wird das Bild des Etablissements eingebunden, wenn es existiert
						if ($etabInfo["img"] == null)
							echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
						else
							echo '
						<img src="../php/db/get_img.php?etab_id=' . $etabInfo["id"] . '" class="card-img-top">';

						// Hier wird das Badge erstellt, ob ein Etablissement verifiziert ist oder nicht
						if ($etabInfo["verifiziert"] == 1) {
							echo '<span class="badge badge-primary rounded-0">Verifiziert</span>';
						} else {
							echo '<span class="badge badge-warning rounded-0">Nicht verifiziert</span>';
						}

						?>
					</div>

					<div class="col-md-10">

						<div class="card-body d-flex flex-column" style="max-height: 200px;">
							<div>
								<h1 class="card-title"> <?php echo $etabInfo["name"]; ?></h1>
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
			// An dieser Stelle werden die Buttons eingefügt, auf die man nur als Admin und/oder Mod Zugriff hat
			if (isset($_SESSION['userId']) && $_SESSION['rang'] > 0) {
				if ($_SESSION['rang'] == 2) {
					$rolle = "Admin";
				} elseif ($_SESSION['rang'] == 1) {
					$rolle = "Moderator";
				}
				echo '
			<div class="accordion mb-3" id="rankTools">
				<div class="card border rounded">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">' . $rolle . ' : ' . $_SESSION['uname'] . '</button>
						</h2>
					</div>
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#rankTools">
						<div class="card-body">';
				echo '
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#etabEdit">Etablissement ändern</button>							
							<div class="modal fade" id="etabEdit" tabindex="-1" role="dialog" aria-labelledby="etabEditTitle" aria-hidden="true">
						  		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
	    							<div class="modal-content">
    	  								<div class="modal-header">
									        <h5 class="modal-title" id="etabEditTitle">Etablissement ändern</h5>
        									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      									</div>
										<form action="../php/etab_edit.php?etab_id=' . $_GET['etab_id'] . '" method="POST" enctype="multipart/form-data">
      										<div class="modal-body">
											  	<div class="form-group">
													<label for="etab-name" class="col-form-label">Etablissement Name:</label>
													<input type="text" class="form-control" id="etab-name" name="etab_name" value=' . $etabInfo["name"] . '>
												</div>
												<div class="form-group">
													<label for="etab-ort" class="col-form-label">Etablissement Ort:</label>
													<input type="text" class="form-control" id="etab-ort" name="etab_ort" value=' . $etabInfo["ort"] . '>
												</div>
												<div class="form-group">
													<label for="etab-anschrift" class="col-form-label">Etablissement Anschrift:</label>
													<input type="text" class="form-control" id="etab-anschrift" name="etab_anschrift" value=' . $etabInfo["anschrift"] . '>
												</div>
												<div class="form-group">
													<label for="img">Bild</label>
													<input type="file" name="file" id="img" class="form-control-file">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Schlie&szlig;en</button>
												<button type="submit" class="btn btn-primary">Änderungen speichern</button>
										  	</div>
										</form>
    								</div>
  								</div>
							</div>';
				if ($etabInfo["verifiziert"] == 1) {
					echo '	<a href="../php/etab_changeVerify.php?etabId=' . $_GET['etab_id'] . '&newVerify=0" class="btn btn-primary" role="button">Verifizierung ändern</a>';
				} elseif ($etabInfo["verifiziert"] == 0) {
					echo '	<a href="../php/etab_changeVerify.php?etabId=' . $_GET['etab_id'] . '&newVerify=1" class="btn btn-primary" role="button">Verifizierung ändern</a>';
				}
				if ($_SESSION['rang'] == 2) {
					echo '                    
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#etabDelete">Etablissement löschen</button>
							<div class="modal fade" id="etabDelete" tabindex="-1" role="dialog" aria-labelledby="etabDeleteLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="etabDeleteLabel">Etablissement löschen?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											Etablissement wirklich löschen?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Schlie&szlig;en</button>
											<a href="../php/etab_delete.php?etabId=' . $_GET['etab_id'] . '" class="btn btn-primary" role="button">L&ouml;schen</a>
										</div>
									</div>
								</div>
							</div>';
				} elseif ($_SESSION['rang'] == 1) {
					echo ' <a href="../php/melden.php?meldungArt=etab&etabId=' . $_GET['etab_id'] . '" class="btn btn-primary" role="button">Etablissement melden</a>';
				}
				echo '
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
				<!-- An dieser Stelle wird eine Tabelle mit den Informationen zu Cocktails erstellt -->
				<div class="tab-content" id="etabDetail-tabContent">
					<div class="tab-pane fade show active" id="cocktailKarte" role="tabpanel" aria-labelledby="cocktailKarte-tab">
						<?php echo '
						<table class="table">
							<thead>
								<tr>
									<th scope="col" style="width: 5.00%">#</th>
									<th scope="col" style="width: 5.00%">Durchschnittsbewertung</th>
									<th scope="col" style="width: 20.00%">Cocktail</th>
									<th scope="col" style="width: 70	.00%">Preis</th>
								</tr>
							</thead> 
							<tbody>';
						for ($i = 0; $i < count($cocktailkarte); $i++) {
							echo '<tr>';
							echo '<th scope="row">' . ($i + 1) . '</th>';
							echo '<td>' . $cocktailkarte[$i]["wert"] . '</td>';
							echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $cocktailkarte[$i]["id"] . '">' . $cocktailkarte[$i]["name"] . '</a></td>';
							echo '<td>' . $cocktailkarte[$i]["preis"] . '€</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<!-- An dieser Stelle wird eine Tabelle mit allen Bewertungen des Etablissements erstellt -->
					<div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertungen-tab">
						<?php
						echo '
						<table class="table">
							<thead>
								<tr>
									<th scope="col" style="width: 5.00%"></th>
									<th scope="col" style="width: 10.00%">Zeitpunkt</th>
									<th scope="col" style="width: 10.00%">Nutzername</th>
									<th scope="col" style="width: 5.00%">Wert</th>
									<th scope="col" style="width: 70.00%">Bewertung</th>
								</tr>
							</thead> 
							<tbody>';
						for ($i = 0; $i < count($etab_bew); $i++) {
							echo '<tr>';
							if (isset($_SESSION['userId'])) {
								if ($_SESSION['rang'] == 2 or $etab_bew[$i]['userId'] == $_SESSION['userId']) {
									echo '<td><a href="../php/bewertung_delete.php?bew_id=' . $etab_bew[$i]["bew_id"] . '&bew=etab"><i class="fas fa-trash"></i></a></td>';
								} elseif ($_SESSION['rang'] == 1) {
									echo '<td><a href="../php/melden.php?meldungArt=etab_bew&etabId=' . $_GET['etab_id'] . '&userId=' . $etab_bew[$i]["userId"] . '"><i class="fas fa-exclamation-triangle"></i></a></th>';
								} else {
									echo '<td></td>';
								}
							} else {
								echo '<td></td>';
							}
							echo '<td>' . $etab_bew[$i]["ts"] . '</td>';
							echo '<td><a href="../site/profil_other.php?showUser=' . $etab_bew[$i]["userId"] . '">' . $etab_bew[$i]["username"] . '</a></td>';
							echo '<td>' . $etab_bew[$i]["wert"] . '</td>';
							echo '<td>' . $etab_bew[$i]["text"] . '</td>';
							echo '</tr>';
						}
						echo '</tbody></table>';
						?>
					</div>
					<!-- An dieser Stelle wird der Bereich zum Bewerten von Etablissements erstellt -->
					<div class="tab-pane fade" id="bewerten" role="tabpanel" aria-labelledby="bewerten-tab">
						<?php
						if (isset($_SESSION['userId'])) {
							echo '
								<form class="mr-2 ml-2 mt-2" action="../php/bewertung_make.php?etab_id=' . $_GET['etab_id'] . '&user_id=' . $_SESSION['userId'] . '" method="post">
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
							echo '<h2 class="ml-4 ct-text-center">Bitte zuerst <a href="signin.php">Anmelden</a>.</h2>';
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