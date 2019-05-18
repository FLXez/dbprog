<?php
session_start();
$activeHead = "user";
$_SESSION['source'] = "../site/profil_other.php?showUser=" . $_GET["showUser"];

if (isset($_SESSION['userId'])) {

    include('../php/db/select_userInfo.php');
    $visitorAdminStatus = $userInfo['admin'];
    $visitorUserName = $userInfo['uname'];
}

//Variable muss immer wieder neu gesetzt werden, da sie am Ende gelöscht wird um Datenverarbeitungsfehler zu vermeiden.
$_SESSION['showUser'] = $_GET['showUser'];
include('../php/db/select_userInfo.php');
$_SESSION['showUser'] = $_GET['showUser'];
include('../php/db/select_user_bewCock.php');
$_SESSION['showUser'] = $_GET['showUser'];
include('../php/db/select_user_bewEtab.php');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ"
        crossorigin="anonymous"></script>
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
            if (isset($_SESSION['message'])) {
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger col-auto ct-text-center" role="alert">';
                    echo $_SESSION['message'];
                    echo '</div>';
                    $_SESSION['error'] = NULL;
                } else {
                    echo '<div class="alert alert-info col-auto ct-text-center" role="alert">';
                    echo $_SESSION['message'];
                    echo '</div>';
                }
                $_SESSION['message'] = NULL;
            }
            ?>
            <div class="card mb-3" width="100%" style="max-height: 360px;">

                <?php
                if (isset($_SESSION['userId']) && $visitorAdminStatus > 0) {
                    if ($visitorAdminStatus == 2) {
                        $rolle = "Admin";
                    } elseif ($visitorAdminStatus == 1) {
                        $rolle = "Mod";
                    }
                    echo '
					<nav class="navbar navbar-expand-lg navbar-light bg-light">

					<a class="navbar-brand" href="#">' . $rolle . ' : ' . $visitorUserName . '</a>
                            <div class="navbar-nav">
                            ';

                                 if ($visitorAdminStatus == 2) {
                                     $_SESSION['changeAdmin_userid'] = $_GET['showUser'];
                                        if ($userInfo['admin'] < 2) {
                                            if ($userInfo['admin'] == 1) {
                                                echo '
                                                <form class="form-inline" action="../php/user_unmod.php">';
                                            } elseif ($userInfo['admin'] == 0) {
                                                echo '
                                                <form class="form-inline" action="../php/user_mod.php">';
                                            }
                                                echo '
                                                <button class="btn btn-primary mt-2 mr-2" type="submit"> Rechte ändern</button>
                                                </form> 
                                                <form class="form-inline" action="../php/db/update_userLoeschen.php">
                                                <button class="btn btn-primary mt-2 mr-2 disabled" type="submit"> User löschen</button>
                                                </form>';    
                                        }
                    }
                    echo '
							</div>
					</nav>';
                }

                ?>


                <div class="row no-gutters">
                    <div class="col-md-2">
                        <?php
                        if ($userInfo['img'])
                            echo '<img src="../php/get_img.php?user_id=' . $_GET['showUser'] . '" class="card-img-top">';
                        else

                            echo '<img src="../res/placeholder_no_image.svg" class="card-img-top">';
                        ?>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body d-flex flex-column" style="max-height: 200px;">
                            <div>
                                <h1 class="card-title">
                                    <?php echo $userInfo["uname"];
                                    echo '                                    
                                        <div class="row float-right mr-1">';
                                    if ($userInfo["admin"] == 2) {
                                        echo '<span class="badge badge-danger">Admin</span>';
                                    } elseif ($userInfo["admin"] == 1) {
                                        if (isset($_SESSION['admin'])) {
                                            if ($_SESSION['admin'] > 1) {
                                                $_SESSION['changeAdmin_userId'] = $_GET['showUser'];
                                                echo '
                                            <a href="../php/user_unmod.php" class="badge badge-primary">Moderator</a>';
                                            }
                                        } else {
                                            echo '<span class="badge badge-primary">Moderator</span>';
                                        }
                                    } elseif ($userInfo["admin"] == 0) {
                                        if (isset($_SESSION['admin'])) {
                                            if ($_SESSION['admin'] > 1) {
                                                $_SESSION['changeAdmin_userId'] = $_GET['showUser'];
                                                echo '
                                            <a href="../php/user_mod.php" class="badge badge-primary">User</a>';
                                            }
                                        } else {
                                            echo '<span class="badge badge-primary">User</span>';
                                        }
                                    }
                                    echo '
                                        </div>';
                                    ?>
                                </h1>
                                <hr>
                            </div>
                            <div class="card-text">
                                <?php
                                echo '
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
                                    </div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <ul class="nav nav-pills flex-column flex-sm-row" id="bewEtabCock-tab" role="tablist">
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link active" id="bewCock-tab" data-toggle="pill" href="#bewCock" role="tab"
                            aria-controls="bewCock" aria-selected="true">Bewertete Cocktails</a>
                    </li>
                    <li class="flex-sm-fill text-sm-center nav-item">
                        <a class="nav-link" id="bewEtab-tab" data-toggle="pill" href="#bewEtab" role="tab"
                            aria-controls="bewEtab" aria-selected="false">Bewertete Etablissements</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content" id="bewEtabCock-tabContent">
                    <div class="tab-pane fade show active" id="bewCock" role="tabpanel" aria-labelledby="bewCock-tab">
                        <?php echo '
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
                            echo '<tr>';
                            echo '<th scope="row">' . ($i + 1);
                            '</th>';
                            echo '<td>' . $user_bewCock[$i]["ts"] . '</td>';
                            echo '<td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewCock[$i]["etabid"] . '">' . $user_bewCock[$i]["etabname"] . '</a></td>';
                            echo '<td> <a class="" href="cocktail_details.php?cock_id= ' . $user_bewCock[$i]["cockid"] . '">' . $user_bewCock[$i]["cockname"] . '</a></td>';
                            echo '<td>' . $user_bewCock[$i]["text"] . '</td>';
                            echo '<td>' . $user_bewCock[$i]["wert"] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
                    <div class="tab-pane fade" id="bewEtab" role="tabpanel" aria-labelledby="bewEtab-tab">
                        <?php echo '
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
                            echo '<tr>';
                            echo '<th scope="row">' . ($i + 1);
                            '</th>';
                            echo '<td>' . $user_bewEtab[$i]["ts"] . '</td>';
                            echo '<td> <a class="" href="etablissement_details.php?etab_id= ' . $user_bewEtab[$i]["id"] . '">' . $user_bewEtab[$i]["name"] . '</a></td>';
                            echo '<td>' . $user_bewEtab[$i]["text"] . '</td>';
                            echo '<td>' . $user_bewEtab[$i]["wert"] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <hr class="ct-hr-divider ml-5 mr-5">
    <footer role="footer" class="container">
        <?php
        include('../php/buildFooter.php');
        ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>