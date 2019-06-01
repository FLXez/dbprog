<!-- Diese HTML Seite stellt die Hauptseite dar -->
<?php
session_start();
$activeHead = "landing";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

// Die Marketingdaten werden aus der Datenbank geladen
include('../php/buildMarketing.php');
include('../php/db/get_marketing.php');
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>The Best E&C</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
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
		<!-- In diesem Bereich wird das Karussel, was oben auf der Hauptseite angezeigt wird, erstellt -->
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <?php
                if (!isset($_SESSION['userId'])) {
                    echo '
                <li data-target="#carousel" data-slide-to="2"></li>';
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="https://cdn2.rsc.org.uk/sitefinity/images/catering/Eating-Drinking/_cocktails.jpg?sfvrsn=26240121_0" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1>Probiert doch unsere neue Suchfunktion!</h1>
                            <p>Wir haben viele Mails bekommen, dass ihr sowas braucht, hier ist sie!</p>
                            <p><a class="btn btn-lg btn-primary" href="../site/suche.php" role="button">Zur Suche</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="https://static.vinepair.com/wp-content/uploads/2015/06/fake-cocktail-bar-liqueurs.jpg" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Wo schmecken die Cocktails am besten?</h1>
                            <p>Hier kommt ihr zur Übersicht aller Etablissements!</p>
                            <p><a class="btn btn-lg btn-primary" href="../site/etablissement_main.php" role="button">Zur Liste</a></p>
                        </div>
                    </div>
                </div>
                <?php
                if (!isset($_SESSION['userId'])) {
                    echo '
                <div class="carousel-item">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <image xlink:href="../res/rating.svg" width="100%" />
                        <rect width="100%" height="100%" fill="#777" fill-opacity="0.5" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1>Du möchtest auch bewerten können?</h1>
                            <p>Dann erstelle Dir noch heute deinen kostenlosen Account und bewerte Cocktails und
                                Etablissements!</p>
                            <p><a class="btn btn-lg btn-primary" href="../site/signin.php" role="button">Registrieren</a></p>
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
		<!-- Dieser Bereich beinhaltet die Marketing-Kacheln -->
        <div class="container marketing">
            <h3 class="mt-2 mb-5 ct-text-center">Empfehlungen der User</h3>
            <div class="row">
                <div class="col-lg-4">
                    <?php
                    buildMarketing($etab1["id"], $etab1["name"], $etab1["img"], $bew1["id"], $bew1["name"], $bew1["text"]);
                    ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    buildMarketing($etab2["id"], $etab2["name"], $etab2["img"], $bew2["id"], $bew2["name"], $bew2["text"]);
                    ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    buildMarketing($etab3["id"], $etab3["name"], $etab3["img"], $bew3["id"], $bew3["name"], $bew3["text"]);
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