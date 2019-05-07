<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$_SESSION['source']= "Location: ../site/profil_main.php";

if ($angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

    if (isset($_GET['updateinfo'])) {
        $statement = $pdo->prepare("
                            UPDATE user 
                                SET vorname = :vorname, nachname = :nachname, age = :age, beruf = :beruf, updated_at = CURRENT_TIMESTAMP 
                            WHERE username = :username");
        $result = $statement->execute(array('vorname' => $_POST['upvname'], 'nachname' => $_POST['upnname'], 'age' => $_POST['upalter'], 'beruf' =>  $_POST['upberuf'], 'username' => $username));
        $emailInUse = $statement->fetch();
    }

    $statement = $pdo->prepare("
                        SELECT id 
                        FROM user 
                        WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $userFetch = $statement->fetch();

    $userid = $userFetch["id"];

    $statement = $pdo->prepare("
                        SELECT * 
                        FROM user 
                        WHERE id = :id");
    $result = $statement->execute(array('id' => $userid));
    $userinfo = $statement->fetch();


    $statement = $pdo->prepare("
                        SELECT  bewertung_etablissement.timestamp, 
                                etablissement.name, 
                                bewertung_etablissement.text, 
                                bewertung_etablissement.wert 
                        FROM bewertung_etablissement 
                            JOIN etablissement 
                                ON bewertung_etablissement.eta_id = etablissement.id 
                        WHERE bewertung_etablissement.user_id = :userid");
    $result = $statement->execute(array('userid' => $userid));
    $etabRatingFetch = $statement->fetchAll();


    $statement = $pdo->prepare("
                        SELECT  bewertung_cocktail.timestamp, 
                                etablissement.name, 
                                cocktail.name, 
                                bewertung_cocktail.text, 
                                bewertung_cocktail.wert 
                        FROM bewertung_cocktail 
                            JOIN cocktail 
                                ON bewertung_cocktail.cocktail_id = cocktail.id 
                            JOIN etablissement 
                                ON bewertung_cocktail.eta_id = etablissement.id 
                        WHERE bewertung_cocktail.user_id = :userid");
    $result = $statement->execute(array('userid' => $userid));
    $cockRatingFetch = $statement->fetchAll();

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

        $statement = $pdo->prepare("
                            SELECT email 
                            FROM user 
                            WHERE email = :email");
        $result = $statement->execute(array('email' => $neuemail));
        $emailInUse = $statement->fetch();
        if ($emailInUse == true) {
            $errNewemail = true;
            $emailchangeError = true;
            $message = "Die E-Mail Addresse ist bereits einem User zugewiesen.";
        } else {
            $statement = $pdo->prepare("
                                SELECT * 
                                FROM user 
                                WHERE username = :username");
            $result = $statement->execute(array('username' => $username));
            $emailfetch = $statement->fetch();

            if ($emailfetch == true && password_verify($emailpw, $emailfetch['passwort'])) {
                $statement = $pdo->prepare("
                                    UPDATE user 
                                        SET email = :email, updated_at = CURRENT_TIMESTAMP 
                                    WHERE username = :username");
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

        $statement = $pdo->prepare("
                            SELECT * 
                            FROM user
                            WHERE username = :username");
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

        if ($altpw == $neupw & $neupw == $neupwconfirm) {
            $pwchangeError = true;
            $message = "Bitte die Eingaben überprüfen.<br>";
        }

        if (!$pwchangeError) {
            if (password_verify($altpw, $user['passwort'])) {
                $neuPasswort_hash = password_hash($neupw, PASSWORD_DEFAULT);
                $statement = $pdo->prepare("
                                    UPDATE user 
                                        SET passwort = :passwort, updated_at = CURRENT_TIMESTAMP 
                                    WHERE username = :username");
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
        <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
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
            <?php
            if ($angemeldet) {
                $statement = $pdo->prepare("
                                    SELECT email 
                                    FROM user 
                                    WHERE username = :username");
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
                echo '
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="profil-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="info-tab" data-toggle="pill" href="#info" role="tab" aria-controls="info" aria-selected="true">Persönliche Informationen</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="cockRating-tab" data-toggle="pill" href="#cockRating" role="tab" aria-controls="cockRating" aria-selected="false">Cocktail Bewertungen</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="etabRating-tab" data-toggle="pill" href="#etabRating" role="tab" aria-controls="etabRating" aria-selected="false">Etablissement Bewertungen</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="setting-tab" data-toggle="pill" href="#setting" role="tab" aria-controls="setting" aria-selected="false">Einstellungen</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="profil-tabContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
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
                        </div>
                    </div>
                    <div class="tab-pane fade" id="cockRating" role="tabpanel" aria-labelledby="cockRating-tab">
                        <div class="mr-5 ml-5 mt-2">
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
                for ($i = 0; $i < count($cockRatingFetch); $i++) {
                    echo '<tr>';
                    echo '<th scope="row">' . ($i + 1);
                    '</th>';
                    echo '<td>' . $cockRatingFetch[$i][0] . '</td>';
                    echo '<td>' . $cockRatingFetch[$i][1] . '</td>';
                    echo '<td>' . $cockRatingFetch[$i][2] . '</td>';
                    echo '<td>' . $cockRatingFetch[$i][3] . '</td>';
                    echo '<td>' . $cockRatingFetch[$i][4] . '</td>';
                    echo '</tr>';
                }
                echo '
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="etabRating" role="tabpanel" aria-labelledby="etabRating-tab">
                        <div class="mr-5 ml-5 mt-2">
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Zeitpunkt</th>
                                <th scope="col">Etablissement</th>
                                <th scope="col">Text</th>
                                <th scope="col">Bewertung</th>
                            </tr>
                        </thead> 
                        <tbody>';
                    for ($i = 0; $i < count($etabRatingFetch); $i++) {
                        echo '<tr>';
                        echo '<th scope="row">' . ($i + 1);
                        '</th>';
                        echo '<td>' . $etabRatingFetch[$i][0] . '</td>';
                        echo '<td>' . $etabRatingFetch[$i][1] . '</td>';
                        echo '<td>' . $etabRatingFetch[$i][2] . '</td>';
                        echo '<td>' . $etabRatingFetch[$i][3] . '</td>';
                        echo '</tr>';
                    }
                echo '      
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
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
                    </div>
                </div>
            </div>';
            } else {
                echo '<div class="card card-body"><h2 class="ct-text-center">Bitte zuerst <a class="ct-panel-group" href="signin.php">Anmelden</a>.</h2></div>';
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