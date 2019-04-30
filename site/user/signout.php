<?php
include('../../php/sessioncheck.php');
$searchActive = "";
$etablissementActive = "";
$cocktailActive = "";
$uberUnsActive ="";
$signout = true;
if ($angemeldet){
    session_destroy();
    header("refresh:5;url=../landing/index.php");
}
?>
<!doctype html>
<html lang="de">

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
    <?php
    include('../../php/buildHeader.php');
    ?>
    <main role="main">
        <?php
        if ($angemeldet){
            echo 
            '
            <h2 class="ct-text-divider">Erfolgreich abgemeldet!</h2>
            <div class="alert alert-info col-auto ct-text-center" role="alert">Automatische Weiterleitung in 5 Sekunden.<br>Falls die automatische Weiterleitung nicht funktionieren sollte, klicken sie bitte <a href="../landing/index.php" class="alert-link">hier</a>.</div>
            ';
        } else {
            echo 
            '
            <h2 class="ct-text-divider">Kein angemeldeter User gefunden.</h2>
            <div class="alert alert-info col-auto ct-text-center" role="alert">Automatische Weiterleitung in 5 Sekunden.<br>Falls die automatische Weiterleitung nicht funktionieren sollte, klicken sie bitte <a href="../landing/index.php" class="alert-link">hier</a>.</div>
            ';
        }
        ?>
    </main>
    <hr class="ct-hr-divider ml-5 mr-5">
    <footer role="footer" class="container">
        <?php
        include('../../php/buildFooter.php');
        ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>