<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$signout = false;

if ($angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
    $message = "";
    $emailchangeError = false;
    $pwchangeError = false;
    $success = false;
    $result = "";

    if (isset($_GET['emailchange'])) {
        $neuemail = $_POST['neuemail'];
        $errNewemail = false;
        $emailpw = $_POST['emailpw'];
        $errEmailpw = false;

        $statement = $pdo->prepare("SELECT email FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $neuemail));
        $emailInUse = $statement->fetch();
        if ($emailInUse == true) {
            $errNewemail = true;
            $emailchangeError = true;
            $message = "Die E-Mail Addresse ist bereits einem User zugewiesen.";
        } else {
            $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $result = $statement->execute(array('username' => $username));
            $emailfetch = $statement->fetch();

            if ($emailfetch == true && password_verify($emailpw, $emailfetch['passwort'])) {
                $statement = $pdo->prepare("UPDATE users SET email = :email, updated_at = CURRENT_TIMESTAMP WHERE username = :username");
                $result = $statement->execute(array('email' => $neuemail, 'username' => $username));
                $updatefetch = $statement->fetch();
                $success = true;
                $message = "Die Email Adresse wurde erfolgreich geändert.";
            } else {
                $errEmailpw = true;
                $emailchangeError = true;
                $message = "Das Passwort ist falsch.";
            }
        }
    }

    if (isset($_GET['pwchange'])) {
        $altpw = $_POST['altpw'];
        $neupw = $_POST['neupw'];
        $neupwconfirm = $_POST['neupwconfirm'];

        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $result = $statement->execute(array('username' => $username));
        $user = $statement->fetch();

        if (password_verify($neupw, $user['passwort'])) { 
            $pwchangeError = true;
            $message = "Das neue Passwort darf nicht mit dem Alten übereinstimmen.<br>";
        }

        if ($neupw != $neupwconfirm) {
            $pwchangeError = true;
            $message .= "Die Eingaben für das neue Passwort stimmen nicht überein.<br>";
        }

        if ($altpw == $neupw & $neupw == $neupwconfirm){
            $pwchangeError = true;
            $message = "Bitte die Eingaben überprüfen.<br>";            
        }

        if (!$pwchangeError){
            if (password_verify($altpw, $user['passwort'])) {
                $neuPasswort_hash = password_hash($neupw, PASSWORD_DEFAULT);
                $statement = $pdo->prepare("UPDATE users SET passwort = :passwort, updated_at = CURRENT_TIMESTAMP WHERE username = :username");
                $result = $statement->execute(array('passwort' => $neuPasswort_hash, 'username' => $username));

                if ($result) {
                    $success = true;
                    $message = "Dein Passwort wurde erfolgreich geändert!";
                } else {
                    $pwchangeError = true;
                    $message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
                }
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
    <title>Profil - Einstellungen</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <?php
            if ($angemeldet) {
                $statement = $pdo->prepare("SELECT email FROM users WHERE username = :username");
                $result = $statement->execute(array('username' => $username));
                $emailaddr = $statement->fetch();
                if ($emailchangeError or $pwchangeError) {
                    echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
                    echo $message;
                    echo '</div>';
                } elseif ($success) {
                    echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
                    echo $message;
                    echo '</div>';
                }
                echo 
                '
                
                ';
            }
            ?>
            <div class="card card-body">
            <?php
            if($angemeldet) {
                echo '
                <h2 class="ml-4">Einstellungen</h2>
                <hr>
                <div>
                    <form class="mr-5 ml-5 mt-2" action="?emailchange=1" method="post">
                        <div class="form-group">
                            <label for="aktemail">Aktuelle E-Mail Addresse</label>
                            <input type="text" class="form-control" id="aktemail" placeholder="' . $emailaddr['email'] . '" readonly>
                        </div>
                        <div class="form-group">
                            <label for="neuemail">Neue E-Mail Addresse eingeben</label>
                            <input type="email" class="form-control" id="neuemail" placeholder="Neue E-Mail Adresse" name="neuemail">
                        </div>
                        <div class="form-group">
                            <label for="emailpw">Aktuelles Passwort eingeben</label>
                            <input type="password" class="form-control" id="emailpw" placeholder="Aktuelles Passwort" name="emailpw">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">E-Mail Adresse ändern</button>
                    </form>
                    <hr class="ct-hr-divider-3 mr-5 ml-5">
                    <form class="mr-5 ml-5 mt-2" action="?pwchange=1" method="post">
                        <div class="form-group">
                            <label for="altpw">Altes Passwort</label>
                            <input type="password" class="form-control" id="altpw" placeholder="Altes Passwort" name="altpw">
                        </div>
                        <div class="form-group">
                            <label for="neupw">Neues Passwort</label>
                            <input type="password" class="form-control" id="neupw" placeholder="Neues Passwort" name="neupw">
                        </div>
                        <div class="form-group">
                            <label for="neupwconfirm">Neues Passwort bestätigen</label>
                            <input type="password" class="form-control" id="neupwconfirm" placeholder="Neues Passwort bestätigen" name="neupwconfirm">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Passwort ändern</button>
                    </form>
                    <br>
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