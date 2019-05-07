<?php
include('../php/sessioncheck.php');
$activeHead = "user";

if ($angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
    $statement = $pdo->prepare("SELECT id FROM user WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $userFetch = $statement->fetch();

    $userid = $userFetch["id"];

    $statement = $pdo->prepare("SELECT bewertung_cocktail.timestamp, etablissement.name, cocktail.name, bewertung_cocktail.text, bewertung_cocktail.wert FROM bewertung_cocktail JOIN cocktail ON bewertung_cocktail.cocktail_id = cocktail.id JOIN etablissement on bewertung_cocktail.eta_id = etablissement.id WHERE bewertung_cocktail.user_id = :userid");
    $result = $statement->execute(array('userid' => $userid));
    $ratingFetch = $statement->fetchAll();
}

?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Profil - Cocktail-Bewertungen</title>
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
            <div class="card card-body">
                <?php
                if ($angemeldet) {
                    echo '
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_main.php">Profil</a>
                        <a class="flex-sm-fill text-sm-center nav-link active" href="../site/profil_cocktailRatings.php">Cocktail-Bewertungen</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_etablissementRatings.php">Etablissement-Bewertungen</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_einstellungen.php">Einstellungen</a>
                    </nav>
                    <hr>
                    <div class="mr-5 ml-5 mt-2">';
                    echo '
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
                    for ($i = 0; $i < count($ratingFetch); $i++) {
                        echo '<tr>';
                        echo '<th scope="row">' . ($i + 1);
                        '</th>';
                        echo '<td>' . $ratingFetch[$i][0] . '</td>';
                        echo '<td>' . $ratingFetch[$i][1] . '</td>';
                        echo '<td>' . $ratingFetch[$i][2] . '</td>';
                        echo '<td>' . $ratingFetch[$i][3] . '</td>';
                        echo '<td>' . $ratingFetch[$i][4] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table></div>';
                } else {
                    echo '<h2 class="ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2>';
                }
                ?>
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