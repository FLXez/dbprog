<?php
include('../php/sessioncheck.php');
$activeHead = "user";
//TODO: Angemeldet unten Seite anders aufbauen
if (!$angemeldet) {

    $message = "";
    $error = false;
    $success = false;

    if (isset($_GET['login'])) {
        $username = $_POST['login_username'];
        //select Passwort von dem Username
        include('../php/db/select_userPrivate.php');
        //User existent und Passwort richtig.
        if ($userPrivate !== false && password_verify($_POST['login_passwort'], $userPrivate['passwort'])) {
            $_SESSION['userid'] = $userPrivate['userid'];
            if (!$_SESSION['source']) {
                header("Location: ../site/index.php");
            } else {
                header($_SESSION['source']);
            }
        } else {
            $error = true;
            $message = "Username oder/und Passwort ungültig!";
        }
    }

    if (isset($_GET['register'])) {

        if ($_POST['register_passwort'] != $_POST['register_passwort_confirm']) {
            $message = "Die Passwörter stimmen nicht überein.<br>";
            $error = true;
        }
        //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
        if (!$error) {
            $newEmail = $_POST['register_email'];
            include('../php/db/check_email.php');
            if ($email_vorhanden) {
                $message .= "Diese E-Mail-Adresse ist bereits vergeben.<br>";
                $error = true;
            }

            $newUsername = $_POST['register_username'];
            include('../php/db/check_username.php');
            if ($username_vorhanden) {
                $message .= "Dieser Username ist bereits vergeben.<br>";
                $error = true;
            }
        }

        //Keine Fehler, wir können den Nutzer registrieren
        if (!$error) {
            include('../php/db/insert_user.php');
            if ($result) {
                $success = true;
                $message = "Du wurdest erfolgreich registriert.";
            } else {
                $error = true;
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
                if ($error) {
                    echo '<div class="alert alert-danger ct-text-center mb-4" role="alert">';
                    echo $message;
                    echo '</div>';
                } elseif ($success) {
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
                                <label for="login_username">Username</label>
                                <input type="text" class="form-control" id="login_username" placeholder="Username" name="login_username" maxlength="25" required>                                
                            </div>
                            <div class="form-group">
                                <label for="login_passwort">Passwort</label>
                                <input type="password" class="form-control" id="login_passwort" placeholder="Passwort" required name="login_passwort" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Anmelden</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form class="mr-5 ml-5 mt-2" action="?register=1" method="post">
                            <div class="form-group">
                                <label for="register_username">Username</label>
                                <input type="text" class="form-control" id="register_username" placeholder="Username" name="register_username" maxlength="25" required>                                
                            </div>
                            <div class="form-group">
                                <label for="register_email">E-Mail Adresse</label>
                                <input type="email" class="form-control" id="register_email" placeholder="E-Mail" name="register_email" maxlenght="50" required>
                            </div>
                            <div class="form-group">
                                <label for="register_passwort">Passwort</label>
                                <input type="password" class="form-control" id="register_passwort" placeholder="Passwort" name="register_passwort" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="register_passwort_confirm" placeholder="Passwort wiederholen" name="register_passwort_confirm" maxlength="20" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrieren</button>
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