<?php
include('../php/sessioncheck.php');
$activeHead = "user";
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
            $_SESSION['userid'] = $user['id'];
            if (!$_SESSION['source']) {
                header("Location: ../site/index.php");
            } else {
                header($_SESSION['source']);
            }
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
        <div class="ml-5 mr-5 mt-5">
            <?php
            if (!$angemeldet) {
                if ($regError or $loginError) {
                    echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
                    echo $message;
                    echo '</div>';
                } elseif ($result) {
                    echo '<div class="alert alert-info col-auto ct-text-center mb-4" role="alert">';
                    echo $message;
                    echo '</div>';
                }
                echo '
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="signin-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="pill" href="#login" role="tab" aria-controls="login" aria-selected="true">Anmelden</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="register-tab" data-toggle="pill" href="#register" role="tab" aria-controls="register" aria-selected="false">Registrieren</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="signin-tabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form class="mr-5 ml-5 mt-2" action="?login=1" method="post">
                            <div class="form-group">
                                <label for="loginUsername">Username</label>
                                <input type="text" class="form-control" id="loginUsername" placeholder="Username" name="loginUsername" required>                                
                            </div>
                            <div class="form-group">
                                <label for="loginPasswort">Passwort</label>
                                <input type="password" class="form-control" id="loginPasswort" placeholder="Passwort" required name="loginPasswort">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Anmelden</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form class="mr-5 ml-5 mt-2" action="?register=1" method="post">
                            <div class="form-group">
                                <label for="registerUsername">Username</label>
                                <input type="text" class="form-control" id="registerUsername" placeholder="Username" name="registerUsername" required>                                
                            </div>
                            <div class="form-group">
                                <label for="registerEmail">E-Mail Adresse</label>
                                <input type="email" class="form-control" id="registerEmail" placeholder="E-Mail" name="registerEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="registerPasswort">Passwort</label>
                                <input type="password" class="form-control" id="registerPasswort" placeholder="Passwort" name="registerPasswort" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="registerPasswortConfirm" placeholder="Passwort wiederholen" name="registerPasswortConfirm" required>
                            </div>
                            <button type="submit" class="btn btn-primary ">Registrieren</button>
                        </form>
                    </div>
                </div>
            </div>';
            } else {
                echo '<div class="card card-body"><h2 class="ct-text-center">Sie sind bereits angemeldet.</h2></div>';
            }
            ?>
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