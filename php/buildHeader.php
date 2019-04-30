<?php
//baut den Header auf.
echo '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="../landing/">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item '.$searchActive.'">
                    <a class="nav-link" href="../search/">Suche</a>
                </li>
                <li class="nav-item dropdown  '.$etablissementActive.'">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown '.$cocktailActive.'">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
				<li class="nav-item dropdown '.$uberUnsActive.'">
				<a class="nav-link dropdown-toggle" href="" id="uberUnsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Über Uns
                    </a>
					 <div class="dropdown-menu" aria-labelledby="uberUnsDropdown">
                        <a class="dropdown-item" href="../thingsNoOneWillRead/team.php">Das Team</a>
                        <a class="dropdown-item" href="../thingsNoOneWillRead/motivation.php">Motivation</a>
						<a class="dropdown-item" href="../thingsNoOneWillRead/impressum.php">Impressum</a>
                    </div>
				</li>
            </ul>';
if ($angemeldet and !$signout) {
    echo '<h5 class="col-auto ct-white">Hallo, <a href="../user/" class="wel-me">' . $username . '!</a></h5>';
    echo '<a href="../user/signout.php" class="btn btn-outline-light" id="abmelden" role="button" aria-pressed="true">Abmelden</a>';            
} else {
    echo '<a href="../user/signin.php" class="btn btn-outline-light" role="button" aria-pressed="true">Anmelden</a>';    
}
echo '
        </div>
    </nav>';