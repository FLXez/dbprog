<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$message = "";
$loginError = false;
$registerError = false;
$result = "";
if (isset($_GET['login'])) {
    $loginUsername = $_POST['loginUsername'];
    $passwort = $_POST['loginPasswort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $loginUsername));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
    } else {
        $loginError = true;
        $message = "Username oder/und Passwort ungültig!";
    }
}

if (isset($_GET['register'])) {
    $regUsername = $_POST['registerUsername'];
    $errUsername = false;
    $regEmail = $_POST['registerEmail'];
    $errEmail = false;
    $regPasswort = $_POST['registerPasswort'];
    $errPasswort = false;
    $regPasswortc = $_POST['registerPasswortConfirm'];
    $errPasswortc = false;

    if ($regPasswort != $regPasswortc) {
        $message = "Die Passwörter stimmen nicht überein.<br>";
        $errPasswortc = true;
        $registerError = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (!$registerError) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $regEmail));
        $user = $statement->fetch();

        if ($user !== false) {
            $message .= "Diese E-Mail-Adresse ist bereits vergeben.<br>";
            $errEmail = true;
            $registerError = true;
        }

        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $result = $statement->execute(array('username' => $regUsername));
        $user = $statement->fetch();

        if ($user !== false) {
            $message .= "Dieser Username ist bereits vergeben.<br>";
            $errEmail = true;
            $registerError = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if (!$registerError) {
        $regPasswort_hash = password_hash($regPasswort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users (email, passwort, username) VALUES (:email, :passwort, :username)");
        $result = $statement->execute(array('email' => $regEmail, 'passwort' => $regPasswort_hash, 'username' => $regUsername));

        if ($result) {
            $message = "Du wurdest erfolgreich registriert.";
        } else {
            $message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Anmelden</title>

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
        <?php
        if ($loginError or $registerError) {
            echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
            echo $message;
            echo '</div>';
        } elseif ($result) {
            echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
            echo $message;
            echo '</div>';
        }
        ?>
        <div id="formswitch" class="ct-panel-group">
            <h2 class="ct-text-divider"><a class="ct-panel-group" id="loginOpener" data-toggle="collapse" href="#loginForm" aria-expanded="true" aria-controls="loginForm">
                    Anmelden</a>...</h2>
            <!--- Hier Anmelden -->
            <div id="loginForm" class="collapse show" aria-labelledby="loginOpener" data-parent="#formswitch">
                <div class="card card-body">
                    <form class="form-inline ct-form-center" action="?login=1" method="post">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Username</div>
                            </div>
                            <input type="text" class="form-control" name="loginUsername" required>
                        </div>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Passwort</div>
                            </div>
                            <input type="password" class="form-control" name="loginPasswort" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Anmelden</button>
                    </form>
                </div>
            </div>
            <!--- Hier Registrieren -->
            <h2 class="ct-text-divider">... oder <a class="ct-panel-group" id="registerOpener" data-toggle="collapse" href="#registerForm" aria-expanded="false" aria-controls="registerForm">
                    Registrieren</a>?</h2>
            <div id="registerForm" class="collapse" aria-labelledby="loginOpener" data-parent="#formswitch">
                <div class="card card-body">
                    <form class="container" action="?register=1" method="post">
                        <div class="form-group row justify-content-md-center">
                            <label for="registerUsername" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="registerUsername" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <label for="registerEmail" class="col-sm-2 col-form-label">E-Mail</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="registerEmail" placeholder="E-Mail" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <label for="registerPasswort" class="col-sm-2 col-form-label">Passwort</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="registerPasswort" placeholder="Passwort" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <!--- Weil Platz sonst kaputt -->
                            <label for="registerPasswortConfirm" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="registerPasswortConfirm" placeholder="Passwort wiederholen" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agbcheck" required>
                                    <label class="form-check-label " for="gridCheck1">
                                        Ich habe die <a href="">AGB's</a> gelesen und zur Kenntnis genommen.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary">Registrieren</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer role="footer">        
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>