<?php
include('../php/sessioncheck.php');
$activeHead = "user";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
                    SELECT username, vorname, nachname, age, beruf, created_at
                    FROM user 
                    WHERE id = :userid");
$result = $statement->execute(array('userid' => $_GET["showUser"]));
$userFetch = $statement->fetch();

$statement = $pdo->prepare("
                    SELECT  bewertung_etablissement.timestamp, 
                            etablissement.name, 
                            bewertung_etablissement.text, 
                            bewertung_etablissement.wert 
                    FROM bewertung_etablissement 
                        JOIN etablissement 
                            ON bewertung_etablissement.eta_id = etablissement.id 
                    WHERE bewertung_etablissement.user_id = :userid");
$result = $statement->execute(array('userid' => $_GET["showUser"]));
$bewEtabFetch = $statement->fetchAll();


$statement = $pdo->prepare("
                    SELECT  bewertung_cocktail.timestamp, 
                            etablissement.name, 
                            cocktail.name, 
                            bewertung_cocktail.text, 
                            bewertung_cocktail.wert 
                    FROM bewertung_cocktail 
                        JOIN cocktail 
                            ON bewertung_cocktail.cocktail_id = cocktail.id 
                        JOIN etablissement 
                            ON bewertung_cocktail.eta_id = etablissement.id 
                    WHERE bewertung_cocktail.user_id = :userid");
$result = $statement->execute(array('userid' => $_GET["showUser"]));
$bewCockFetch = $statement->fetchAll();

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
            <div class="card mb-3" width="100%" style="max-height: 360px;">
                <div class="row no-gutters">
                    <div class="col-md-2">
                        <?php
                        //Bild aus der Datenbank ziehen, later!
                        if (true)
                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        else

                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title"> <?php echo $userFetch["username"]; ?> </h1>
                            <p class="card-text">
                                <?php
                                echo '
                                <div class="row">
                                    <div class="col-2">
                                        Vorname: 
                                    </div>
                                    <div class="col-10">'
                                    . $userFetch["vorname"] .
                                    '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Nachname: 
                                    </div>
                                    <div class="col-10">'
                                    . $userFetch["nachname"] .
                                    '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Alter: 
                                    </div>
                                    <div class="col-10">'
                                    . $userFetch["age"] .
                                    '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Beruf: 
                                    </div>
                                    <div class="col-10">'
                                    . $userFetch["beruf"] .
                                    '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Mitglied seit: 
                                    </div>
                                    <div class="col-10">'
                                    . $userFetch["created_at"] .
                                    '</div>
                                </div>';
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="bewCock-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="bewCock-tab" data-toggle="pill" href="#bewCock" role="tab" aria-controls="bewCock" aria-selected="true">Bewertete Cocktails</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="bewEtab-tab" data-toggle="pill" href="#bewEtab" role="tab" aria-controls="bewEtab" aria-selected="false">Bewertete Etablissements</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="bewCock-tabContent">
                    <div class="tab-pane fade show active" id="bewCock" role="tabpanel" aria-labelledby="bewCock-tab">
                        <?php echo '
						<table class="table">
							<thead>
								<tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Zeitpunkt</th>
                                    <th scope="col">Etablissement</th>
                                    <th scope="col">Cocktail</th>
                                    <th scope="col">Text</th>
                                    <th scope="col">Bewertung</th>
								</tr>
							</thead> 
							<tbody>';
                        for ($i = 0; $i < count($bewCockFetch); $i++) {
                            echo '<tr>';
                            echo '<th scope="row">' . ($i + 1);
                            '</th>';
                            echo '<td>' . $bewCockFetch[$i][0] . '</td>';
                            echo '<td>' . $bewCockFetch[$i][1] . '</td>';
                            echo '<td>' . $bewCockFetch[$i][2] . '</td>';
                            echo '<td>' . $bewCockFetch[$i][3] . '</td>';
                            echo '<td>' . $bewCockFetch[$i][4] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
                    <div class="tab-pane fade" id="bewEtab" role="tabpanel" aria-labelledby="bewEtab-tab">
                        <?php echo '
						<table class="table">
							<thead>
								<tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Zeitpunkt</th>
                                    <th scope="col">Etablissement</th>
                                    <th scope="col">Text</th>
                                    <th scope="col">Bewertung</th>
								</tr>
							</thead> 
							<tbody>';
                        for ($i = 0; $i < count($bewEtabFetch); $i++) {
                            echo '<tr>';
                            echo '<th scope="row">' . ($i + 1);
                            '</th>';
                            echo '<td>' . $bewEtabFetch[$i][0] . '</td>';
                            echo '<td>' . $bewEtabFetch[$i][1] . '</td>';
                            echo '<td>' . $bewEtabFetch[$i][2] . '</td>';
                            echo '<td>' . $bewEtabFetch[$i][3] . '</td>';
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