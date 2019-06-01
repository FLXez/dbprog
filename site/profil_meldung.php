<!-- Diese HTML Seite dient der Darstellung von Meldungen für Admins -->
<?php
session_start();
$activeHead = "user";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

// Wenn kein Admin, dann Weiterleitung auf Profil-Hauptseite
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] < 2) {
        header("Location: profil_main.php");
    }
} else {
    header("Location: profil_main.php");
}

// Offene und Geschlossene Meldungen werden aus der Datenbank geladen
include('../php/db/select_meldungOpen.php');
include('../php/db/select_meldungClosed.php');
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Meldungen</title>
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
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="meldung-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="meldOpen-tab" data-toggle="pill" href="#meldOpen" role="tab" aria-controls="meldOpen" aria-selected="true">Offene Meldungen</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="meldClosed-tab" data-toggle="pill" href="#meldClosed" role="tab" aria-controls="meldClosed" aria-selected="false">Geschlossene Meldungen</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="meldung-tabContent">
					<!-- In diesem Bereich wird die Tabelle der offenen Meldungen zusammengestellt -->
                    <div class="tab-pane fade show active" id="meldOpen" role="tabpanel" aria-labelledby="meldOpen-tab">
                        <?php
                        echo '
					    <table class="table">
						    <thead>
							    <tr>
								    <th scope="col" style="width: 10.00%">Zeitpunkt</th>
                                    <th scope="col" style="width: 10.00%">Meldungsart</th>
                                    <th scope="col" style="width: 18.25%">Melder</th>
								    <th scope="col" style="width: 18.25%">Etablissement Name</th>
                                    <th scope="col" style="width: 18.25%">Cocktail Name</th>
                                    <th scope="col" style="width: 18.25%">Nutzer Name</th>
                                    <th scope="col" style="width: 2.00%"></th>
                                    <th scope="col" style="width: 2.00%"></th>
							    </tr>
						    </thead> 
					        <tbody>';
                        for ($i = 0; $i < count($meldInfoOpen); $i++) {
                            echo '<tr>';
                            echo '<td>' . $meldInfoOpen[$i]["m_ts"] . '</td>';
                            echo '<td>' . $meldInfoOpen[$i]["m_art"] . '</td>';
                            echo '<td><a href="../site/profil_other.php?showUser=' . $meldInfoOpen[$i]["m_mid"] . '">' . $meldInfoOpen[$i]["um_name"] . '</a></td>';
                            echo '<td><a href="../site/etablissement_details.php?etab_id=' . $meldInfoOpen[$i]["m_eid"] . '">' . $meldInfoOpen[$i]["e_name"] . '</a></td>';
                            echo '<td><a href="../site/cocktail_details.php?cock_id=' . $meldInfoOpen[$i]["m_cid"] . '">' . $meldInfoOpen[$i]["c_name"] . '</a></td>';
                            echo '<td><a href="../site/profil_other.php?showUser=' . $meldInfoOpen[$i]["m_uid"] . '">' . $meldInfoOpen[$i]["uu_name"] . '</a></td>';
                            echo '<td><a class="mr-2" href="../php/meldung_update.php?meld_id=' . $meldInfoOpen[$i]["m_id"] . '&status=1"><i class="fas fa-check"></i></a></td>';
                            echo '<td><a href="../php/meldung_delete.php?meld_id=' . $meldInfoOpen[$i]["m_id"] . '"><i class="fas fa-times"></i></a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
					<!-- In diesem Bereich wird die Tabelle der geschlossenen Meldungen zusammengestellt -->
                    <div class="tab-pane fade" id="meldClosed" role="tabpanel" aria-labelledby="meldClosed-tab">
                    <?php
                        echo '
					    <table class="table">
						    <thead>
							    <tr>
								    <th scope="col" style="width: 10.00%">Zeitpunkt</th>
                                    <th scope="col" style="width: 10.00%">Meldungsart</th>
                                    <th scope="col" style="width: 18.25%">Melder</th>
								    <th scope="col" style="width: 18.25%">Etablissement Name</th>
                                    <th scope="col" style="width: 18.25%">Cocktail Name</th>
                                    <th scope="col" style="width: 18.25%">Nutzer Name</th>
                                    <th scope="col" style="width: 2.00%"></th>
                                    <th scope="col" style="width: 2.00%"></th>
							    </tr>
						    </thead> 
					        <tbody>';
                        for ($i = 0; $i < count($meldInfoClosed); $i++) {
                            echo '<tr>';
                            echo '<td>' . $meldInfoClosed[$i]["m_ts"] . '</td>';
                            echo '<td>' . $meldInfoClosed[$i]["m_art"] . '</td>';
                            echo '<td><a href="../site/profil_other.php?showUser=' . $meldInfoClosed[$i]["m_mid"] . '">' . $meldInfoClosed[$i]["um_name"] . '</a></td>';
                            echo '<td><a href="../site/etablissement_details.php?etab_id=' . $meldInfoClosed[$i]["m_eid"] . '">' . $meldInfoClosed[$i]["e_name"] . '</a></td>';
                            echo '<td><a href="../site/cocktail_details.php?cock_id=' . $meldInfoClosed[$i]["m_cid"] . '">' . $meldInfoClosed[$i]["c_name"] . '</a></td>';
                            echo '<td><a href="../site/profil_other.php?showUser=' . $meldInfoClosed[$i]["m_uid"] . '">' . $meldInfoClosed[$i]["uu_name"] . '</a></td>';
                            echo '<td><a class="mr-2" href="../php/meldung_update.php?meld_id=' . $meldInfoClosed[$i]["m_id"] . '&status=0"><i class="fas fa-undo"></i></a></td>';
                            echo '<td><a href="../php/meldung_delete.php?meld_id=' . $meldInfoClosed[$i]["m_id"] . '"><i class="fas fa-trash"></i></a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
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