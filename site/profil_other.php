<!-- Diese HTML Seite beinhaltet die Sicht auf ein fremdes Profil -->
<?php
session_start();
$activeHead = "user";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

// Wenn die aufgerufene Seite die vom eigenen Profil ist, weiterleitung auf Profil-Hauptseite
if (isset($_SESSION['userId'])) {
    if ($_SESSION['userId'] == $_GET['showUser']) {
        header("Location: profil_main.php");
    }
}

// Die Öffentlichen Daten des angezeigten Users werden aus der Datenbank geladen
$userId = $_GET['showUser'];
include('../php/db/select_userInfo.php');
include('../php/db/select_user_bewCock.php');
include('../php/db/select_user_bewEtab.php');
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Profil</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS Toolbox -->
    <link href="../css/csstoolbox.css" rel="stylesheet">
</head>

<body class="center-block">
    <header role="header">
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
						// An dieser Stelle wird das Profilbild eingebunden, wenn es vorhanden ist
                        if ($userInfo['img']) {
                            echo '<img src="../php/db/get_img.php?user_id=' . $_GET['showUser'] . '" class="card-img-top">';
                        } else {
                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        }
						// An dieser Stelle wird das Badge des User-Rangs angezeigt
                        if ($userInfo["rang"] == 2) {
                            echo '<span class="badge badge-danger rounded-0">Admin</span>';
                        } elseif ($userInfo["rang"] == 1) {
                            echo '<span class="badge badge-primary rounded-0">Moderator</span>';
                        } elseif ($userInfo["rang"] == 0) {
                            echo '<span class="badge badge-primary rounded-0">User</span>';
                        }
                        ?>
                    </div>
					<!-- An dieser Stelle werden die User-Informationen dargestellt -->
                    <div class="col-md-10">
                        <div class="card-body d-flex flex-column" style="max-height: 200px;">
                            <div>
                                <h1 class="card-title"><?php echo $userInfo["uname"]; ?></h1>
                                <hr>
                            </div>
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-2">Vorname: </div>
                                    <div class="col-10"><?php echo $userInfo['vname'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Nachname: </div>
                                    <div class="col-10"><?php echo $userInfo['nname'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Alter: </div>
                                    <div class="col-10"><?php echo $userInfo['age'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Beruf: </div>
                                    <div class="col-10"><?php echo $userInfo['beruf'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Mitglied seit: </div>
                                    <div class="col-10"><?php echo $userInfo['ts'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
			// Wenn der angemeldete User Admin oder Mod ist, wird hier der zusätzliche Admin-Bereich aufgebaut
            if (isset($_SESSION['userId']) && $_SESSION['rang'] >= 1) {
                if ($_SESSION['rang'] == 2) {
                    $rolle = "Admin";
                } elseif ($_SESSION['rang'] == 1) {
                    $rolle = "Moderator";
                }
                echo '
					<div class="accordion mb-3" id="rankTools">
                        <div class="card border">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">'  . $rolle . ' : ' . $_SESSION['uname'] . '</button>
                                </h2>
	                        </div>
	                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#rankTools">
                                <div class="card-body">';
				// Admins können den Rang eines Users zum Mod ändern oder andersrum
                if ($_SESSION['rang'] == 2) {
                    if ($userInfo['rang'] == 1) {
                        echo '      <a href="../php/user_changeRang.php?userId=' . $_GET['showUser'] . '&newRang=0" class="btn btn-primary" role="button">Rechte ändern</a>';
                    } elseif ($userInfo['rang'] == 0) {
                        echo '      <a href="../php/user_changeRang.php?userId=' . $_GET['showUser'] . '&newRang=1" class="btn btn-primary" role="button">Rechte ändern</a>';
                    }
					// Wenn der angesehene User nur User oder Mod ist (Also kein Admin), kann der User gelöscht werden
					// Auswahl zwischen Hard- und Soft-Delete. Hard-Delete löscht den User Kaskadierend, also auch sämtliche Bewertungen
					// Soft-Delete löscht den Nutzer nur scheinbar, in Wahrheit wird der Nutzer nur in "Nutzer gelöscht" umbenannt
					// So sind Bewertungen weiterhin verfügbar
                    if ($userInfo['rang'] <= 1) {
                        echo '                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userDelete">User löschen</button>
                                    <div class="modal fade" id="userDelete" tabindex="-1" role="dialog" aria-labelledby="userDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="userDeleteLabel">User löschen?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    "Soft-Delete": Bewertungen bleiben erhalten. <br>
                                                    "Hard-Delete": Auch abgegebene Bewertungen werden gelöscht.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Schlie&szlig;en</button>
                                                    <a href="../php/user_delete.php?soft=1&userId=' . $_GET['showUser'] . '" class="btn btn-primary" role="button">Soft-Delete</a>
                                                    <a href="../php/user_delete.php?soft=0&userId=' . $_GET['showUser'] . '" class="btn btn-primary" role="button">Hard-Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                    }
				// Moderatoren können User melden
                } elseif ($_SESSION['rang'] == 1) {
                    echo '          <a href="../php/melden.php?meldungArt=user&userId=' . $_GET['showUser'] . '" class="btn btn-primary" role="button">Nutzer melden</a>';
                }
                echo '          </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="bewEtabCock-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="bewCock-tab" data-toggle="pill" href="#bewCock" role="tab" aria-controls="bewCock" aria-selected="true">Bewertete Cocktails</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="bewEtab-tab" data-toggle="pill" href="#bewEtab" role="tab" aria-controls="bewEtab" aria-selected="false">Bewertete Etablissements</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="bewEtabCock-tabContent">
                    <div class="tab-pane fade show active" id="bewCock" role="tabpanel" aria-labelledby="bewCock-tab">
                        <?php 
						// An dieser Stelle wird die Tabelle der abgegebenen Bewertungen von Cocktails aufgebaut
						echo '
						<table class="table">
							<thead>
								<tr>
                                    <th scope="col" style="width: 5.00%"></th>
                                    <th scope="col" style="width: 10.00%">Zeitpunkt</th>
                                    <th scope="col" style="width: 10.00%">Etablissement</th>
                                    <th scope="col" style="width: 10.00%">Cocktail</th>
                                    <th scope="col" style="width: 5.00%">Bewertung</th>
                                    <th scope="col" style="width: 60.00%">Text</th>
								</tr>
							</thead> 
							<tbody>';
                        for ($i = 0; $i < count($user_bewCock); $i++) {
                            echo '<tr>';
							// Admins können Bewertungen direkt löschen, Mods nur melden
                            if (isset($_SESSION['userId'])) {
                                if ($_SESSION['rang'] == 2) {
                                    echo '<td><a href="../php/bewertung_delete.php?bew_id=' . $user_bewCock[$i]["bew_id"] . '&bew=cock"><i class="fas fa-trash"></i></a></td>';
                                } elseif ($_SESSION['rang'] == 1) {
                                    echo '<td><a href="../php/melden.php?meldungArt=cock_bew&cockId=' . $user_bewCock[$i]["cockid"] . '&userId=' . $_GET['showUser'] . '"><i class="fas fa-exclamation-triangle"></i></a></th>';
                                } else {
                                    echo '<td></td>';
                                }
                            } else {
                                echo '<td></td>';
                            }
                            echo '<td>' . $user_bewCock[$i]["ts"] . '</td>';
                            echo '<td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewCock[$i]["etabid"] . '">' . $user_bewCock[$i]["etabname"] . '</a></td>';
                            echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $user_bewCock[$i]["cockid"] . '">' . $user_bewCock[$i]["cockname"] . '</a></td>';
                            echo '<td>' . $user_bewCock[$i]["wert"] . '</td>';
                            echo '<td>' . $user_bewCock[$i]["text"] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
                    <div class="tab-pane fade" id="bewEtab" role="tabpanel" aria-labelledby="bewEtab-tab">
                        <?php 
						// An dieser Stelle wird die Tabelle zur Anzeige von allen Etablissement-Bewertungen aufgebaut
						echo '
						<table class="table">
							<thead>
								<tr>
                                    <th scope="col" style="width: 5.00%"></th>
                                    <th scope="col" style="width: 10.00%">Zeitpunkt</th>
                                    <th scope="col" style="width: 10.00%">Etablissement</th>
                                    <th scope="col" style="width: 5.00%">Bewertung</th>
                                    <th scope="col" style="width: 70.00%">Text</th>
								</tr>
							</thead> 
							<tbody>';
                        for ($i = 0; $i < count($user_bewEtab); $i++) {
                            echo '<tr>';
							// Admins können Bewertungen direkt löschen, Mods nur melden
                            if (isset($_SESSION['userId'])) {
                                if ($_SESSION['rang'] == 2) {
                                    echo '<td><a href="../php/bewertung_delete.php?bew_id=' . $user_bewEtab[$i]["bew_id"] . '&bew=etab"><i class="fas fa-trash"></i></a></td>';
                                } elseif ($_SESSION['rang'] == 1) {
                                    echo '<td><a href="../php/melden.php?meldungArt=etab_bew&etabId=' . $user_bewEtab[$i]["id"] . '&userId=' . $_GET['showUser'] . '"><i class="fas fa-exclamation-triangle"></i></a></th>';
                                } else {
                                    echo '<td></td>';
                                }
                            } else {
                                echo '<td></td>';
                            }
                            echo '<td>' . $user_bewEtab[$i]["ts"] . '</td>';
                            echo '<td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewEtab[$i]["id"] . '">' . $user_bewEtab[$i]["name"] . '</a></td>';
                            echo '<td>' . $user_bewEtab[$i]["wert"] . '</td>';
                            echo '<td>' . $user_bewEtab[$i]["text"] . '</td>';
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