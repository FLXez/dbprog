<?php
$searchActive = "";
$cocktailActive = "";
$etablissementActive = "";
$uberUnsActive = "";
//baut den Header auf.
if ($activeHead == "search") {
    $searchActive = "active";
} elseif ($activeHead == "etablissement") {
    $etablissementActive = "active";
} elseif ($activeHead == "cocktail") {
    $cocktailActive = "active";
} elseif ($activeHead == "uberUns") {
    $uberUnsActive = "active";
}

echo '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="../site/">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ' . $searchActive . '">
                    <a class="nav-link" href="../site/suche.php">Suche</a>
                </li>
                <li class="nav-item dropdown  ' . $etablissementActive . '">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../site/etablissement_main.php">Übersicht</a>
                        <a class="dropdown-item" href="../site/etablissement_new.php">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown ' . $cocktailActive . '">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../site/cocktail_main.php">Übersicht</a>
                        <a class="dropdown-item" href="../site/cocktail_new.php">Neuer Cocktail</a>
                    </div>
                </li>
				<li class="nav-item dropdown ' . $uberUnsActive . '">
				<a class="nav-link dropdown-toggle" href="" id="uberUnsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Über Uns
                    </a>
					 <div class="dropdown-menu" aria-labelledby="uberUnsDropdown">
                        <a class="dropdown-item" href="../site/about_team.php">Das Team</a>
                        <a class="dropdown-item" href="../site/about_motivation.php">Motivation</a>
						<a class="dropdown-item" href="../site/about_impressum.php">Impressum</a>
                    </div>
				</li>
            </ul>';
if (isset($_SESSION['userid']) and !isset($signout)) {
    echo '<a href="../site/profil_main.php" class="profil-nav mr-3"><i class="far fa-user"></i> Profil</a>';
    echo '<a href="../site/signout.php" class="profil-nav"><i class="fas fa-lock"></i> Abmelden</a>';
} else {
    echo '<a href="../site/signin.php" class="profil-nav"><i class="fas fa-unlock"></i> Anmelden</a>';
}
echo '
        </div>
    </nav>';
