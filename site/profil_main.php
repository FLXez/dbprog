<?php
session_start();
$activeHead = "user";
$_SESSION['source'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    include('../php/db/select_user_bewCock.php');
    include('../php/db/select_user_bewEtab.php');
    include('../php/db/select_userInfo.php');
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
            if (isset($_SESSION['userId'])) {
                include('../php/alertMessage.php');
                echo '
            <div class="card mb-3" width="100%" style="max-height: 360px;">
                <div class="row no-gutters">
                    <div class="col-md-2">';
                if ($userInfo["img"]) {
                    echo '
                        <img src="../php/db/get_img.php?user_id=' . $userId . '" class="card-img-top">';
                } else {
                    echo '
                        <img src="../res/placeholder_no_image.svg" class="card-img-top">';
                }

                echo ' 
                    </div>
                    <div class="col-md-10">
                        <div class="card-body d-flex flex-column" style="max-height: 200px;">
                            <div>
                                <h1 class="card-title">' . $userInfo["uname"];
                if ($_SESSION['admin'] == 1) {
                    echo '
                                <span class="badge badge-primary float-right">Mod</span>';
                } elseif ($_SESSION['admin'] == 2) {
                    echo '
                                <span class="badge badge-danger float-right">Admin</span>';
                }
                echo '
                                </h1>
                                <hr>
                            </div>
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-2">Vorname: </div>
                                    <div class="col-10">' . $userInfo["vname"] . '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Nachname: </div>
                                    <div class="col-10">' . $userInfo["nname"] . '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Alter: </div>
                                    <div class="col-10">' . $userInfo["age"] . '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Beruf: </div>
                                    <div class="col-10">' . $userInfo["beruf"] . '</div>
                                </div>
                                <div class="row">
                                    <div class="col-2">Mitglied seit: </div>
                                    <div class="col-10">' . $userInfo["ts"] . '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>';
                if (isset($_SESSION['userId']) && $userInfo['admin'] > 0) {
                    if ($userInfo['admin'] == 2) {
                        $rolle = "Admin";
                    } elseif ($userInfo['admin'] == 1) {
                        $rolle = "Mod";
                    }
                    echo '
            <div class="accordion mb-3" id="accordionExample">
                <div class="card border rounded">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">' . $rolle . ' : ' . $userInfo['uname'] . '</button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">';
                    if ($userInfo['admin'] == 1) {
                        echo '
                            <form class="form-inline" action="../php/userUnmod_self.php">
                                <button class="btn btn-primary mt-2 mr-2" type="submit"> Rechte ändern</button>
                            </form>';
                    } else {
                        echo 'Kein Inhalt anzeigbar.';
                    }
                    echo '
                        </div>
                    </div>
                </div>
            </div>';
                }
                echo '
            <div class="card card-body">
            <ul class="nav nav-pills flex-column flex-sm-row" id="profil-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                    <a class="nav-link active" id="setting-tab" data-toggle="pill" href="#setting" role="tab" aria-controls="setting" aria-selected="true">Informationen und Einstellungen</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                    <a class="nav-link" id="bewCock-tab" data-toggle="pill" href="#bewCock" role="tab" aria-controls="bewCock" aria-selected="false">Bewertete Cocktails</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="bewEtab-tab" data-toggle="pill" href="#bewEtab" role="tab" aria-controls="bewEtab" aria-selected="false">Bewertete Etablissements</a>
                    </li>
                </ul>
                <hr>                
                <div class="tab-content" id="profil-tabContent">
                    <div class="tab-pane fade show active" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <form action="../php/db/update_userInfo.php" method="post">
                                <div class="form-group">
                                    <label for="u_ui_vname">Vorname</label>
                                    <input type="text" maxlength="50" class="form-control" id="u_ui_vname" name="u_ui_vname" value="' . $userInfo['vname'] . '" placeholder="Vorname">
                                </div>
                                <div class="form-group">
                                    <label for="u_ui_nname">Nachname</label>
                                    <input type="text" maxlength="25" class="form-control" id="u_ui_nname" name="u_ui_nname" value="' . $userInfo['nname'] . '" placeholder="Nachname">
                                </div>
                                <div class="form-group">
                                    <label for="u_ui_age">Alter</label>
                                    <input type="number" max="127" class="form-control" id="u_ui_age" name="u_ui_age" value="' . $userInfo['age'] . '" placeholder="Alter">
                                </div>
                                <div class="form-group">
                                    <label for="u_ui_beruf">Beruf</label>
                                    <input type="text" maxlength="25" class="form-control" id="u_ui_beruf" name="u_ui_beruf" value="' . $userInfo['beruf'] . '" placeholder="Beruf">
                                </div>
                            <button type="submit" class="btn btn-primary mt-2">Informationen aktualisieren</button>
                        </form>

                        <hr class="ct-hr-divider-2">
                        <form action="../php/db/update_userPic.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
							<label for="file"><h5>Bild aktualisieren</h5></label>
                            <input type="file" name="file" id="file" class="form-control-file"> 	
                            <button type="submit" class="btn btn-primary mt-3">Aktualisieren</button>
						</div>
                        </form>

                        <hr class="ct-hr-divider-2">
                        <form action="../php/db/update_userEmail.php" method="post">
                            <div class="form-group">
                                <label for="u_ue_emailOld">Aktuelle E-Mail Addresse</label>
                                <input type="email" class="form-control" id="u_ue_emailOld" placeholder="' . $userInfo['email'] . '" readonly>
                            </div>
                            <div class="form-group">
                                <label for="u_ue_emailNew">Neue E-Mail Addresse eingeben</label>
                                <input type="email" class="form-control" id="u_ue_emailNew" placeholder="Neue E-Mail Adresse" name="u_ue_emailNew" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="u_ue_password">Aktuelles Passwort eingeben</label>
                                <input type="password" class="form-control" id="u_ue_password" placeholder="Aktuelles Passwort" name="u_ue_password" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">E-Mail Adresse ändern</button>
                        </form>
                        <hr class="ct-hr-divider-2">
                        <form action="../php/db/update_userPassword.php" method="post">
                            <div class="form-group">
                                <label for="u_up_passOld">Altes Passwort</label>
                                <input type="password" class="form-control" id="u_up_passOld" placeholder="Altes Passwort" name="u_up_passOld" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="u_up_passNew">Neues Passwort</label>
                                <input type="password" class="form-control" id="u_up_passNew" placeholder="Neues Passwort" name="u_up_passNew" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label for="u_up_passNew_confirm">Neues Passwort bestätigen</label>
                                <input type="password" class="form-control" id="u_up_passNew_confirm" placeholder="Neues Passwort bestätigen" name="u_up_passNew_confirm" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Passwort ändern</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="bewCock" role="tabpanel" aria-labelledby="bewCock-tab">
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
                for ($i = 0; $i < count($user_bewCock); $i++) {
                    echo '      <tr>';
                    echo '          <th scope="row">' . ($i + 1) . '</th>';
                    echo '          <td>' . $user_bewCock[$i]["ts"] . '</td>';
                    echo '          <td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewCock[$i]["etabid"] . '">' . $user_bewCock[$i]["etabname"] . '</a></td>';
                    echo '          <td> <a class="" href="cocktail_details.php?cock_id= ' . $user_bewCock[$i]["cockid"] . '">' . $user_bewCock[$i]["cockname"] . '</a></td>';
                    echo '          <td>' . $user_bewCock[$i]["text"] . '</td>';
                    echo '          <td>' . $user_bewCock[$i]["wert"] . '</td>';
                    echo '      </tr>';
                }
                echo '      </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bewEtab" role="tabpanel" aria-labelledby="bewEtab-tab">                    
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
                for ($i = 0; $i < count($user_bewEtab); $i++) {
                    echo '      <tr>';
                    echo '          <th scope="row">' . ($i + 1) . '</th>';
                    echo '          <td>' . $user_bewEtab[$i]["ts"] . '</td>';
                    echo '          <td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewEtab[$i]["id"] . '">' . $user_bewEtab[$i]["name"] . '</a></td>';
                    echo '          <td>' . $user_bewEtab[$i]["text"] . '</td>';
                    echo '          <td>' . $user_bewEtab[$i]["wert"] . '</td>';
                    echo '      </tr>';
                }
                echo '      </tbody>
                        </table>
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