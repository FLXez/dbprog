<?php
include('../php/sessioncheck.php');
$activeHead = "landing";
$_SESSION['source'] = "Location: ../site/index.php";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

$statement = $pdo->prepare(
    "SELECT DISTINCT
				e.id as id,
				e.name as name
			FROM etab e
			JOIN bew_etab be ON
				e.id = be.etab_id
			WHERE
				e.verifiziert = 1 AND
				be.wert in ('3','4','5') AND
				e.img IS NOT NULL"
);
$result = $statement->execute();
$etab_ids = $statement->fetchAll();
$etab_ids_count = count($etab_ids);

if($etab_ids_count>3){

$etab1 = $etab_ids[rand(1, $etab_ids_count) - 1];
$etab2 = $etab1;
$etab3 = $etab1;

while ($etab2[0] == $etab1[0]) {
    $etab2 = $etab_ids[rand(1, $etab_ids_count) - 1];
}

while ($etab3[0] == $etab1[0] || $etab3[0] == $etab2[0]) {
    $etab3 = $etab_ids[rand(1, $etab_ids_count) - 1];
}
}else{
$statement = $pdo->prepare(
    "SELECT DISTINCT
				e.id as id,
				e.name as name
			FROM etab e
			JOIN bew_etab be ON
				e.id = be.etab_id");
$result = $statement->execute();
$etab_ids = $statement->fetchAll();
$etab_ids_count = count($etab_ids);



$etab1 = $etab_ids[rand(1, $etab_ids_count) - 1];
$etab2 = $etab1;
$etab3 = $etab1;

while ($etab2[0] == $etab1[0]) {
    $etab2 = $etab_ids[rand(1, $etab_ids_count) - 1];
}

while ($etab3[0] == $etab1[0] || $etab3[0] == $etab2[0]) {
    $etab3 = $etab_ids[rand(1, $etab_ids_count) - 1];

}
}

$statement = $pdo->prepare(
    "SELECT
				be.text as text,
				u.username as name,
                u.id as id
			FROM bew_etab be
			JOIN user u ON
				be.user_id = u.id
			WHERE
				be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab1[0]));
$bew1Fetch = $statement->fetchAll();
$bew1Fetch_count = count($bew1Fetch);

$bew1 = $bew1Fetch[rand(1, $bew1Fetch_count) - 1];

$statement = $pdo->prepare(
    "SELECT
				be.text as text,
				u.username as name,
                u.id as id
			FROM bew_etab be
			JOIN user u ON
				be.user_id = u.id
			WHERE
				be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab2[0]));
$bew2Fetch = $statement->fetchAll();
$bew2Fetch_count = count($bew2Fetch);

$bew2 = $bew2Fetch[rand(1, $bew2Fetch_count) - 1];

$statement = $pdo->prepare(
    "SELECT
				be.text as text,
				u.username as name,
                u.id as id
			FROM bew_etab be
			JOIN user u ON
				be.user_id = u.id
			WHERE
				be.etab_id = :etab_id"
);
$result = $statement->execute(array('etab_id' => $etab3[0]));
$bew3Fetch = $statement->fetchAll();
$bew3Fetch_count = count($bew3Fetch);

$bew3 = $bew3Fetch[rand(1, $bew3Fetch_count) - 1];

?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Hameln E&C</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS aus Template übernommen, placeholder -->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Landing CSS -->
    <link href="../css/landing.css" rel="stylesheet">
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
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
				<?php
				if(!$angemeldet){
				echo'
                <li data-target="#carousel" data-slide-to="2"></li>';
				}
				?>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="https://cdn2.rsc.org.uk/sitefinity/images/catering/Eating-Drinking/_cocktails.jpg?sfvrsn=26240121_0" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1>Beste Cocktails in 2019</h1>
                            <p>Ihr habt gewählt! Die besten Cocktails des Jahres in einer Übersicht.</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Weiterlesen</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="https://static.vinepair.com/wp-content/uploads/2015/06/fake-cocktail-bar-liqueurs.jpg" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Wo schmecken die Cocktails am besten?</h1>
                            <p>Wir haben eine Liste der besten Etablissements zusammengestellt und wollen Euch diese
                                natürlich nicht vorenthalten!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Zur Liste</a></p>
                        </div>
                    </div>
                </div>
				<?php
				if(!$angemeldet){
				echo '
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="../res/rating.svg" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1>Du möchtest auch bewerten? FlExIbLeLaBeLs</h1>
                            <p>Dann erstelle Dir noch heute deinen kostenlosen Account und bewerte Cocktails und
                                Etablissements!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Registrieren</a></p>
                        </div>
                    </div>
                </div>';
				}
				?>


            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Zurück</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Weiter</span>
            </a>
        </div>
        <div class="container marketing">
            <h3 class="mt-2 ct-text-center">Empfehlungen der User</h3>
            <div class="row">
                <div class="col-lg-4">
                    <?php
                    echo '<img src="../php/get_img.php?etab_id=' . $etab1["id"] . '" class="rounded-circle" height="200px" width="200px">';
                    echo '<h2>' . $etab1["name"] . '</h2>';
                    echo '<p>' . $bew1["text"] . ' <br>(von <a class="" href="../site/profil_other.php?showUser=' . $bew1["id"] . '">' . $bew1["name"] . '</a>)</p>';
                    echo '<p><a class="btn btn-primary" href="./etablissement_details.php?etab_id=' . $etab1[0] . '" role="button">Weitere Informationen &raquo;</a></p>'; ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    echo '<img src="../php/get_img.php?etab_id=' . $etab2["id"] . '" class="rounded-circle" height="200px" width="200px">';
                    echo '<h2>' . $etab2["name"] . '</h2>';
                    echo '<p>' . $bew2["text"] . ' <br>(von <a class="" href="../site/profil_other.php?showUser=' . $bew2["id"] . '">' . $bew2["name"] . '</a>)</p>';
                    echo '<p><a class="btn btn-primary" href="./etablissement_details.php?etab_id=' . $etab2[0] . '" role="button">Weitere Informationen &raquo;</a></p>'; ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    echo '<img src="../php/get_img.php?etab_id=' . $etab3["id"] . '" class="rounded-circle" height="200px" width="200px">';
                    echo '<h2>' . $etab3["name"] . '</h2>';
                    echo '<p>' . $bew3["text"] . ' <br>(von <a class="" href="../site/profil_other.php?showUser=' . $bew3["id"] . '">' . $bew3["name"] . '</a>)</p>';
                    echo '<p><a class="btn btn-primary" href="./etablissement_details.php?etab_id=' . $etab3[0] . '" role="button">Weitere Informationen &raquo;</a></p>'; ?>
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