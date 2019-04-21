<?php
session_start();
session_destroy();
header("refresh:5;url=../landing/index.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Abmeldung</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CSS Toolbox -->
    <link href="../../css/csstoolbox.css" rel="stylesheet">
</head>

<body class="center-block">
    <header role="header">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../landing/">Start</a>
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
                <a href="signin.php" class="btn btn-outline-light" role="button" aria-pressed="true">Anmelden</a>
            </div>
        </nav>
    </header>
    <main role="main">
        <h2 class="ct-text-divider">Erfolgreich abgemeldet!</h2>
        <div class="alert alert-info col-auto ct-text-center" role="alert">Automatische Weiterleitung in 5 Sekunden.<br>Falls die automatische Weiterleitung nicht funktionieren sollte, klicken sie bitte <a href="../landing/index.php" class="alert-link">hier</a>.</div>
    </main>
    <footer role="footer">
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>