<?php
//baut den Header auf.
if ($headerActive == "landing") {
    echo '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../landing/">Start</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
            </ul>';
}
elseif ($headerActive == "etablissement") {
    echo
        '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../landing/">Start</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
            </ul>';
}
elseif ($headerActive == "cocktail") {
    echo
        '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../landing/">Start</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
            </ul>';
}
elseif ($headerActive == "user") {
    echo
        '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../landing/">Start</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
            </ul>';
}
else {
    echo
        '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#Easteregg">Hameln E&C</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../landing/">Start</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="etablissementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etablissements</a>
                    <div class="dropdown-menu" aria-labelledby="etablissementDropdown">
                        <a class="dropdown-item" href="../etablissement/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neues Etablissement</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="cocktailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cocktails
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cocktailDropdown">
                        <a class="dropdown-item" href="../cocktail/">Übersicht</a>
                        <a class="dropdown-item" href="#">Neuer Cocktail</a>
                    </div>
                </li>
            </ul>';
}
include('../../php/signbuttons.php');
echo '
        </div>
    </nav>';