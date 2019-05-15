<?php
include('../php/sessioncheck.php');
$activeHead = "user";
$_SESSION['source'] = "Location: ../site/profil_main.php";

if ($angemeldet) {
    $userid = $_SESSION['userid'];

    if (isset($_GET['update_userInfo'])) {
        include('../php/db/update_userInfo.php');
    }

    include('../php/db/select_user_bewCock.php');
    include('../php/db/select_user_bewEtab.php');


    $message = "";
    $error = false;
    $success = false;

    if (isset($_GET['update_userEmail'])) {
        //Passwort aus der Datenbank ziehen.
        include('../php/db/select_userPrivate.php');
        //Wird die gewünschte neue Email bereits verwendet?
        $newEmail = $_POST['u_ue_emailNew'];
        include('../php/db/check_email.php');
        if ($email_vorhanden == true) {
            $error = true;
            $message = "Die E-Mail Addresse ist bereits einem User zugewiesen.";
        } elseif (password_verify($_POST['u_ue_password'], $userPrivate['passwort'])) {
            //gewünschte Email frei, Passwort korrekt?
            include("../php/db/update_userEmail.php");
            if ($result) {
                $success = true;
                $message = "Die Email Adresse wurde erfolgreich geändert.";
            } else {
                $error = true;
                $message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
            }
        } else {
            //Passwort ist falsch
            $error = true;
            $message = "Das Passwort ist falsch.";
        }
    }

    if (isset($_GET['update_userPasswort'])) {
        //Passwort aus der Datenbank ziehen.
        include('../php/db/select_userPrivate.php');

        //Eingaben für das neue Passwort übereinstimmend?
        if ($_POST['u_up_passNew'] != $_POST['u_up_passNew_confirm']) {
            $error = true;
            $message .= "Die Eingaben für das neue Passwort stimmen nicht überein.<br>";
        } elseif (password_verify($_POST['u_up_passOld'], $userPrivate['passwort'])) {
            //Passwort updaten
            include('../php/db/update_userPassword.php');
            if ($result) {
                $success = true;
                $message = "Dein Passwort wurde erfolgreich geändert!";
            } else {
                $error = true;
                $message = "Es ist ein Fehler aufgetreten, bitte versuche es später erneut.";
            }
        } else {
            //Passwort ist falsch.
            $error = true;
            $message = "Das Passwort ist faslch.";
        }
    }

    if(isset($_GET['update_userPic'])){

        $file_name = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		$file_size = $_FILES['file']['size'];
        $file_tem_loc = $_FILES['file']['tmp_name'];
        
        if ($file_name) {
			$handle = fopen($file_tem_loc, 'r');
			$image = fread($handle, $file_size);
		} else {
			$image = "";
        }


        include('../php/db/update_userPic.php');

        if($result){
            $success = true;
            $message= "Dein Bild wurde aktualisiert.";
        }else{
            $error = true;
            $message= "Es ist ein Fehler beim aktualisieren des Bildes aufgetreten.";
        }

    }

    if(isset($_GET['admin'])){
        $admin = $_GET['admin'];
        include('../php/db/update_adminstatus.php');
        if($result){
            $success = true;
            $message= "Modstatus wurde aktualisiert.";
        }else{
            $error = true;
            $message= "Es ist ein Fehler beim aktualisieren des Modstatuses aufgetreten.";
        }
    }
    //Einlesen der ggf. updateten Userdaten
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
            if ($angemeldet) {
                if ($error) {
                    echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
                    echo $message;
                    echo '</div>';
                } elseif ($success) {
                    echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
                    echo $message;
                    echo '</div>';
                }
                echo '
                <div class="card mb-3" width="100%" style="max-height: 360px;">
                <div class="row no-gutters">
                    <div class="col-md-2">';
                if ($userInfo["img"]){
                    echo '<img src="../php/get_img.php?user_id=' . $userid . '" class="card-img-top">';
                }else{
                    echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                    
                }

                echo ' 
                    </div>
                    <div class="col-md-10">
                        <div class="card-body d-flex flex-column" style="max-height: 200px;">
                            <div>
                                <h1 class="card-title">' . $userInfo["uname"];
                                if($userInfo["admin"] == 1) {
                                    echo '
                                            <span class="badge badge-primary float-right">Mod</span>';
                                }elseif($userInfo["admin"]== 2){
                                    echo '
                                    <span class="badge badge-primary float-right">Admin</span>';
                                }
                                echo '</h1>
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
                                    <div>';
                                    
                                    if($angemeldet){
    
                                        if($userInfo["admin"]==1){
                                            
                                            echo '
                                            <form action="?admin=0" method="POST">
                                            <button type="submit" class="btn btn-primary mt-2">Zurücktreten als Mod</button>
                                            </form>';
                                        }
                                    }
                                    echo '
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        <form action="?update_userInfo=1" method="post">
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
                        <form action="?update_userPic=1" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
							<label for="file">Bild aktualisieren</label>
                            <input type="file" name="file" id="file" class="form-control-file"> 	
                            <button type="submit" class="btn btn-primary mt-2">Aktualisieren</button>
						</div>
                        </form>

                        <hr class="ct-hr-divider-2">
                        <form action="?update_userEmail=1" method="post">
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
                        <form action="?update_userPasswort=1" method="post">
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