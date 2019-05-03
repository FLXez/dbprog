<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$signout = false;

if ($angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

    if (isset($_GET['updateinfo'])) { 
        $upvname = $_POST['upvname'];
        $upnname = $_POST['upnname'];
        $upalter = $_POST['upalter'];
        $upberuf = $_POST['upberuf'];
        $statement = $pdo->prepare("UPDATE user SET vorname = :vorname, nachname = :nachname, age = :age, beruf = :beruf WHERE username = :username");
        $result = $statement->execute(array('vorname' => $upvname, 'nachname' => $upnname, 'age' => $upalter, 'beruf' => $upberuf, 'username' => $username));
        $emailInUse = $statement->fetch();
    }

    $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $userinfo = $statement->fetch();
}

?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
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
            <div class="card card-body mr-2">
                <?php
                if ($angemeldet) {
                    echo '
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link active" href="../site/profil_main.php">Profil</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_cocktailRatings.php">Cocktail-Bewertungen</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_etablissementRatings.php">Etablissement-Bewertungen</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="../site/profil_einstellungen.php">Einstellungen</a>
                    </nav>
                    <hr>
                    <div class="mr-5 ml-5 mt-2">
                        <h5>Persönliche Informationen - Alle Angaben sind freiwillig</h5>
                        <hr>
                        <form action="?updateinfo=1" method="post">
                        <div class="form-group">
                            <label for="upvname">Vorname</label>
                            <input type="text" maxlength="50" class="form-control" id="upvname" name="upvname" value="' . $userinfo['vorname'] . '" placeholder="Vorname">
                        </div>
                        <div class="form-group">
                            <label for="upnname">Nachname</label>
                            <input type="text" maxlength="50" class="form-control" id="upnname" name="upnname" value="' . $userinfo['nachname'] . '" placeholder="Nachname">
                        </div>
                        <div class="form-group">
                            <label for="upalter">Alter</label>
                            <input type="number" max="127" class="form-control" id="upalter" name="upalter" value="' . $userinfo['age'] . '" placeholder="Alter">
                        </div>
                        <div class="form-group">
                            <label for="upberuf">Beruf</label>
                            <input type="text" maxlength="50" class="form-control" id="upberuf" name="upberuf" value="' . $userinfo['beruf'] . '" placeholder="Beruf">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Informationen aktualisieren</button>
                    </form>
                    </div>';
                } else {
                    echo '<h2 class="ml-4 ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2>';
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