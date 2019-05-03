<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$signout = false;
//TODO: Angemeldet unten Seite anders aufbauen
if (!$angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
    $message = "";
    $loginError = false;
    $regError = false;
    $result = "";
    if (isset($_GET['login'])) {
        $loginUsername = $_POST['loginUsername'];
        $passwort = $_POST['loginPasswort'];

        $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $result = $statement->execute(array('username' => $loginUsername));
        $user = $statement->fetch();

        //Überprüfung des Passworts
        if ($user !== false && password_verify($passwort, $user['passwort'])) {
            $_SESSION['username'] = $user['username'];
            header('Location: ../site/index.php  ');
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
        $regPasswortconfirm = $_POST['registerPasswortConfirm'];
        $errPasswortconfirm = false;

        if ($regPasswort != $regPasswortconfirm) {
            $message = "Die Passwörter stimmen nicht überein.<br>";
            $errPasswortconfirm = true;
            $regError = true;
        }

        //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
        if (!$regError) {
            $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
            $result = $statement->execute(array('email' => $regEmail));
            $user = $statement->fetch();

            if ($user !== false) {
                $message .= "Diese E-Mail-Adresse ist bereits vergeben.<br>";
                $errEmail = true;
                $regError = true;
            }

            $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username");
            $result = $statement->execute(array('username' => $regUsername));
            $user = $statement->fetch();

            if ($user !== false) {
                $message .= "Dieser Username ist bereits vergeben.<br>";
                $errEmail = true;
                $regError = true;
            }
        }

        //Keine Fehler, wir können den Nutzer registrieren
        if (!$regError) {
            $regPasswort_hash = password_hash($regPasswort, PASSWORD_DEFAULT);

            $statement = $pdo->prepare("INSERT INTO user (email, passwort, username) VALUES (:email, :passwort, :username)");
            $result = $statement->execute(array('email' => $regEmail, 'passwort' => $regPasswort_hash, 'username' => $regUsername));

            if ($result) {
                $message = "Du wurdest erfolgreich registriert.";
            } else {
                $regError = true;
                $message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
            }
        }
    }
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
    <title>Hameln E&C - Anmelden</title>

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
        <?php
        if (!$angemeldet) {
            if ($regError or $loginError) {
                echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
                echo $message;
                echo '</div>';
            } elseif ($result) {
                echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
                echo $message;
                echo '</div>';
            }
            echo '
        <div id="formswitch" class="ct-panel-group mr-5 ml-5">
            <h2 class="ct-text-divider"><a class="ct-panel-group" id="loginOpener" data-toggle="collapse" href="#loginForm" aria-expanded="true" aria-controls="loginForm">
                    Anmelden</a>...</h2>
            <!--- Hier Anmelden -->
            <div id="loginForm" class="collapse show mr-5 ml-5" aria-labelledby="loginOpener" data-parent="#formswitch">
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
            <div id="registerForm" class="collapse mr-5 ml-5" aria-labelledby="loginOpener" data-parent="#formswitch">
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
                                        Ich habe die <a href="">AGBs</a> gelesen und zur Kenntnis genommen.
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
        </div>';
        } else {
            header("refresh:5;url=../landing/index.php");
            echo
                '
            <h2 class="ct-text-divider">Sie sind bereits angemeldet.</h2>
            <div class="alert alert-info col-auto ct-text-center" role="alert">Automatische Weiterleitung in 5 Sekunden.<br>Falls die automatische Weiterleitung nicht funktionieren sollte, klicken sie bitte <a href="../landing/index.php" class="alert-link">hier</a>.</div>
            ';
        }
        ?>
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