﻿<?php
//Ist eine Session offen?
session_start();

$angemeldet = false;

if (isset($_SESSION['username'])) {
    $angemeldet = true;
    $username = $_SESSION['username'];
} else {
    $angemeldet = false;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Hameln E&C</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        a.wel-me:link {
            color: #FFFFFF;
            text-decoration: underline;
        }

        a.wel-me:visited {
            color: #FFFFFF;
            text-decoration: underline;
        }

        a.wel-me:hover {
            color: #afafaf;
            text-decoration: underline;
        }

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
    <!-- Custom styles for this template -->
    <link href="../../css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="">Start<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Etablissements
                        </a>
                        <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                            <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                            <a class="dropdown-item" href="#">Neues Etablissement</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cocktails
                        </a>
                        <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                            <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                            <a class="dropdown-item" href="#">Neuer Cocktail</a>
                        </div>
                    </li>
                </ul>
                <?php
                if ($angemeldet) {
                    echo '<h5 style="color: white" class="col-auto">Hallo, <a href="#" class="wel-me">' . $username . '!</a></h5>';
                    echo '<a href="signout.php" class="btn btn-outline-light" id="abmelden" role="button" aria-pressed="true">Abmelden</a>';
                } else {
                    echo '<a href="signin.php" class="btn btn-outline-light" role="button" aria-pressed="true">Anmelden</a>';
                }
                ?>
            </div>
        </nav>
    </header>

    <main role="main">
        <!-- Top 3 Cocktails -->
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <rect width="100%" height="100%" fill="#777" /></svg>
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
                        <rect width="100%" height="100%" fill="#777" /></svg>
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Wo schmecken die Cocktails am besten?</h1>
                            <p>Wir haben eine Liste der besten Etablissements zusammengestellt und wollen Euch diese
                                natürlich nicht vorenthalten!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Zur Liste</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <rect width="100%" height="100%" fill="#777" /></svg>
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1>Du möchtest auch bewerten? FlExIbLeLaBeLs</h1>
                            <p>Dann erstelle Dir noch heute deinen kostenlosen Account und bewerte Cocktails und
                                Etablissements!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Registrieren</a></p>
                        </div>
                    </div>
                </div>
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


        <!-- Marketing messaging and featurettes
  ================================================== -->
        <!-- Wrap the rest of the page in another container to center all the content. -->
        <div class="container marketing">
            <!-- Three columns of text below the carousel -->
            <div class="row">
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>
                    <h2>Etablissement X</h2>
                    <p>Kurzbeschreibung des Etablissements</p>
                    <p><a class="btn btn-secondary" href="#" role="button">Weitere Informationen &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>
                    <h2>Etablissement Y</h2>
                    <p>Kurzbeschreibung des Etablissements</p>
                    <p><a class="btn btn-secondary" href="#" role="button">Weitere Informationen &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>
                    <h2>Etablissement Ich denke nicht nach wenn ich Kopiere</h2>
                    <p>Felix hatte nicht nachgedacht beim kopieren. 4 Sterne. Würde ich nicht wieder hingehen.</p>
                    <p><a class="btn btn-secondary" href="#" role="button">Weitere Informationen &raquo;</a></p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->


            <!-- START THE FEATURETTES -->

            <hr class="featurette-divider">
            <div class="container">
                <div class="row justify-content-center">
                    <h1>Über diese Website</h1>
                </div>
            </div>
            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">Diese Seite...</h2>
                    <p class="lead">... ist auf Basis eines Projekts in der Uni entstanden. <br> <i>"Was wäre, wenn ich
                            trinken
                            gehen will und genau weiß, wo welcher Cocktail wie gut schmeckt?"</i> <br>Das war die Idee,
                        die zur Entstehung dieser Website geführt hat.</p>
                </div>
                <div class="col-md-5">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading">Das Team...</h2>
                    <p class="lead">... besteht aus Philipp Potraz, Felix Pause und Cedrick Bargel. Wir drei lieben
                        Cocktails mindestens genauso sehr wie ihr!</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
                    <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis
                        euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus,
                        tellus ac cursus commodo.</p>
                </div>
                <div class="col-md-5">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            <!-- /END THE FEATURETTES -->

        </div><!-- /.container -->


        <!-- FOOTER -->
        <footer class="container">
            <p class="float-right"><a href="#">Back to top</a></p>
            <p>&copy; 2019 Schwanger Cocktails. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>