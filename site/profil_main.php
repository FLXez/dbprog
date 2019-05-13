<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$_SESSION['source'] = "Location: ../site/profil_main.php";

if ($angemeldet) {

    $pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

    if (isset($_GET['updateinfo'])) {
        $statement = $pdo->prepare("
                            UPDATE user 
                                SET vorname = :vorname, nachname = :nachname, age = :age, beruf = :beruf, updated_at = CURRENT_TIMESTAMP 
                            WHERE id = :userid");
        $result = $statement->execute(array('vorname' => $_POST['upvname'], 'nachname' => $_POST['upnname'], 'age' => $_POST['upalter'], 'beruf' =>  $_POST['upberuf'], 'userid' => $_SESSION['userid']));
        $emailInUse = $statement->fetch();
    }

    //muss danach kommen, damit nach update die neuen infos drin stehen!
    $statement = $pdo->prepare("
                        SELECT * 
                        FROM user 
                        WHERE id = :userid");
    $result = $statement->execute(array('userid' => $_SESSION['userid']));
    $userinfo = $statement->fetch();


    $statement = $pdo->prepare("
    SELECT  bewertung_cocktail.timestamp as ts, 
            etablissement.name as etabname,
            etablissement.id as etabid, 
            cocktail.name as cockname, 
            cocktail.id as cockid,
            bewertung_cocktail.text as text, 
            bewertung_cocktail.wert as wert 
    FROM bewertung_cocktail 
        JOIN cocktail 
            ON bewertung_cocktail.cocktail_id = cocktail.id 
        JOIN etablissement 
            ON bewertung_cocktail.eta_id = etablissement.id 
    WHERE bewertung_cocktail.user_id = :userid");
    $result = $statement->execute(array('userid' => $_SESSION["userid"]));
    $bewCockFetch = $statement->fetchAll();


    $statement = $pdo->prepare("
    SELECT  bewertung_etablissement.timestamp as ts, 
            etablissement.name as name,
            etablissement.id as id, 
            bewertung_etablissement.text as text, 
            bewertung_etablissement.wert as wert 
    FROM bewertung_etablissement 
        JOIN etablissement 
            ON bewertung_etablissement.eta_id = etablissement.id 
    WHERE bewertung_etablissement.user_id = :userid");
    $result = $statement->execute(array('userid' => $_SESSION["userid"]));
    $bewEtabFetch = $statement->fetchAll();

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
        } elseif ($userinfo == true && password_verify($emailpw, $userinfo['passwort'])) {
            $statement = $pdo->prepare("
                                UPDATE user 
                                    SET email = :email, updated_at = CURRENT_TIMESTAMP 
                                WHERE userid = :userid");
            $result = $statement->execute(array('email' => $neuemail, 'userid' => $_SESSION['userid']));
            $emailUpdate = $statement->fetch();
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
                            WHERE userid = :userid");
    $result = $statement->execute(array('userid' => $_SESSION['userid']));
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
                                    WHERE userid = :userid");
            $result = $statement->execute(array('passwort' => $neuPasswort_hash, 'userid' => $_SESSION['userid']));

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
                             <div class="mt-5 ml-5 mr-5">


							 <div class="card mb-3" width="100%" style="max-height: 360px;">
                <div class="row no-gutters">
                    <div class="col-md-2">';
                        
                        //Bild aus der Datenbank ziehen, later!
                        if (true)
                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        else

                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        echo'
                    </div>
                    <div class="col-md-10">
                        <div class="card-body d-flex flex-column" style="height: 230px;">
                            <div>
                                <h1 class="card-title">'. 
								 $userinfo["username"].' </h1>
                                <hr>
                            </div>
                            <div>
                                <p class="card-text">';
                                    
                                    echo '
                                <div class="row">
                                    <div class="col-2">
                                        Vorname: 
                                    </div>
                                    <div class="col-10">'
                                        . $userinfo["vorname"] .
                                        '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Nachname: 
                                    </div>
                                    <div class="col-10">'
                                        . $userinfo["nachname"] .
                                        '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Alter: 
                                    </div>
                                    <div class="col-10">'
                                        . $userinfo["age"] .
                                        '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Beruf: 
                                    </div>
                                    <div class="col-10">'
                                        . $userinfo["beruf"] .
                                        '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        Mitglied seit: 
                                    </div>
                                    <div class="col-10">'
                                        . $userinfo["created_at"] .
                                        '</div>
                                </div>';
                                    echo'
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
							

                        </div>
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
                for ($i = 0; $i < count($bewCockFetch); $i++) {
                    echo '<tr>';
                    echo '<th scope="row">' . ($i + 1);
                    '</th>';
                    echo '<td>' . $bewCockFetch[$i]["ts"] . '</td>';
                    echo '<td> <a class="" href="etablissement_details.php?eta_id= ' . $bewCockFetch[$i]["etabid"] . '">' . $bewCockFetch[$i]["etabname"] . '</a></td>';
                    echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $bewCockFetch[$i]["cockid"] . '">' . $bewCockFetch[$i]["cockname"] . '</a></td>';
                    echo '<td>' . $bewCockFetch[$i]["text"] . '</td>';
                    echo '<td>' . $bewCockFetch[$i]["wert"] . '</td>';
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
                for ($i = 0; $i < count($bewEtabFetch); $i++) {
                    echo '<tr>';
                    echo '<th scope="row">' . ($i + 1);
                    '</th>';
                    echo '<td>' . $bewEtabFetch[$i]["ts"] . '</td>';
                    echo '<td> <a class="" href="etablissement_details.php?eta_id= ' . $bewEtabFetch[$i]["id"] . '">' . $bewEtabFetch[$i]["name"] . '</a></td>';
                    echo '<td>' . $bewEtabFetch[$i]["text"] . '</td>';
                    echo '<td>' . $bewEtabFetch[$i]["wert"] . '</td>';
                    echo '</tr>';
                }
                echo '      
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">

                            <form  class="mr-5 ml-5 mt-2" action="?updateinfo=1" method="post">
							<h5>Persönliche Informationen und Accounteinstellungen</h5>
                            <hr>
                                <div class="form-group">
                                    <label for="upvname">Vorname</label>
                                    <input type="text" maxlength="50" class="form-control" id="upvname" name="upvname" value="' . $userinfo['vorname'] . '" placeholder="Vorname">
                                </div>
                                <div class="form-group">
                                    <label for="upnname">Nachname</label>
                                    <input type="text" maxlength="25" class="form-control" id="upnname" name="upnname" value="' . $userinfo['nachname'] . '" placeholder="Nachname">
                                </div>
                                <div class="form-group">
                                    <label for="upalter">Alter</label>
                                    <input type="number" max="127" class="form-control" id="upalter" name="upalter" value="' . $userinfo['age'] . '" placeholder="Alter">
                                </div>
                                <div class="form-group">
                                    <label for="upberuf">Beruf</label>
                                    <input type="text" maxlength="25" class="form-control" id="upberuf" name="upberuf" value="' . $userinfo['beruf'] . '" placeholder="Beruf">
                                </div>
                            <button type="submit" class="btn btn-primary mt-2">Informationen aktualisieren</button>
                            </form>
							<hr class="ct-hr-divider-3 mr-5 ml-5">

                        <form class="mr-5 ml-5 mt-2" action="?emailchange=1" method="post">
                            <div class="form-group">
                                <label for="aktemail">Aktuelle E-Mail Addresse</label>
                                <input type="text" class="form-control" id="aktemail" placeholder="' . $userinfo['email'] . '" readonly>
                            </div>
                            <div class="form-group">
                                <label for="neuemail">Neue E-Mail Addresse eingeben</label>
                                <input type="email" class="form-control" id="neuemail" placeholder="Neue E-Mail Adresse" name="neuemail" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="emailpw">Aktuelles Passwort eingeben</label>
                                <input type="password" class="form-control" id="emailpw" placeholder="Aktuelles Passwort" name="emailpw" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">E-Mail Adresse ändern</button>
                        </form>
                        <hr class="ct-hr-divider-3 mr-5 ml-5">
                        <form class="mr-5 ml-5 mt-2" action="?pwchange=1" method="post">
                            <div class="form-group">
                                <label for="altpw">Altes Passwort</label>
                                <input type="password" class="form-control" id="altpw" placeholder="Altes Passwort" name="altpw" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="neupw">Neues Passwort</label>
                                <input type="password" class="form-control" id="neupw" placeholder="Neues Passwort" name="neupw" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="neupwconfirm">Neues Passwort bestätigen</label>
                                <input type="password" class="form-control" id="neupwconfirm" placeholder="Neues Passwort bestätigen" name="neupwconfirm" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Passwort ändern</button>
                        </form>
                    </div>
                </div>
            </div>';
            } else {
                echo '<div class="card card-body"><h2 class="ct-text-center">Bitte zuerst <a class="" href="signin.php">Anmelden</a>.</h2></div>';
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