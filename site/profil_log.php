<!-- Diese HTML Seite beinhaltet die Anzeige von Logdaten (Nur sichtbar für Admins) -->
<?php
session_start();
$activeHead = "user";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

// Wenn kein Admin, weiterleitung auf Hauptseite des Profils
if (isset($_SESSION['userId'])) {
    if ($_SESSION['rang'] < 2) {
        header("Location: profil_main.php");
    }
} else {
    header("Location: profil_main.php");
}

include('../php/db/select_log.php');
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Moderator-Log</title>
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
                <h2 class="ml-2">Moderator-Log</h2>
                <hr>
                <div class="ml-2">
                    <?php
					// An dieser Stelle wird die Tabelle erstellt, in der die Logdaten angezeigt werden
                    echo '
					<table class="table">
						<thead>
							<tr>
								<th scope="col" style="width: 10.00%">Zeitpunkt</th>
                                <th scope="col" style="width: 10.00%">Aktion</th>
                                <th scope="col" style="width: 22.00%">Moderator</th>
								<th scope="col" style="width: 24.00%">Etablissement Name</th>
                                <th scope="col" style="width: 24.00%">Cocktail Name</th>
							</tr>
						</thead> 
					    <tbody>';
                    for ($i = 0; $i < count($logInfo); $i++) {
                        echo '<tr>';
                        echo '<td>' . $logInfo[$i]["lts"] . '</td>';
                        echo '<td>' . $logInfo[$i]["aktion"] . '</td>';
                        echo '<td><a href="../site/profil_other.php?showUser=' . $logInfo[$i]["mod_id"] . '">' . $logInfo[$i]["uname"] . '</a></td>';
                        echo '<td><a href="../site/etablissement_details.php?etab_id=' . $logInfo[$i]["eid"] . '">' . $logInfo[$i]["ename"] . '</a></td>';
                        echo '<td><a href="../site/cocktail_details.php?cock_id=' . $logInfo[$i]["cid"] . '">' . $logInfo[$i]["cname"] . '</a></td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
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