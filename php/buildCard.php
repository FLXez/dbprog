<!-- Dieses PHP Subscript stellt Funktionen Bereit, um das HTML der Karten für die Etablissements und Cocktails zusammenzustellen -->
<?php
function buildCard_etab($id, $name, $ort, $anschrift, $verifiziert, $avgwert, $img, $anz)
{
    echo '
    <div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
    if ($img == null) {
        echo '
            <img src="../res/placeholder_no_image.svg" class="card-img-top" height="302" width="302">';
    } else {
        echo '
            <img src="../php/db/get_img.php?etab_id=' . $id . '" class="card-img-top" height="302" width="302">';
    }
    if ($verifiziert == 1) {
        echo '<span class="badge badge-primary rounded-0">Verifiziert</span>';
    } else {
        echo '<span class="badge badge-warning rounded-0">Nicht verifiziert</span>';
    }
    echo '
        <div class="card-body d-flex flex-column">
			<div class="row">
				<div class="col-12">
				    <h5 class="card-title">' . $name . '</h5>
                </div>
            </div>
		    <div class="row">
			    <div class="col-12">	
					<p class="card-text">' . $ort . '<br>' . $anschrift . '</p>
				</div>
            </div>
            <div class="mt-auto">
                <hr style="margin-left: 0; margin-right: 0;">
                <div class="row">
                    <div class="col-4">
                        <h5 class="rating-num float-left">' . number_format($avgwert, 1) . '</h5>
                    </div>
                    <div class="col-8">
                        <div class="rating float-right">';
    if ($avgwert >= 1)           echo '<i class="fas fa-star"></i>';
    else                         echo '<i class="far fa-star"></i>';
    if ($avgwert >= 1.75)        echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 1.25)    echo '<i class="fas fa-star-half-alt"></i>';
    else                         echo '<i class="far fa-star"></i>';
    if ($avgwert >= 2.75)        echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 2.25)    echo '<i class="fas fa-star-half-alt"></i>';
    else                         echo '<i class="far fa-star"></i>';
    if ($avgwert >= 3.75)        echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 3.25)    echo '<i class="fas fa-star-half-alt"></i>';
    else                         echo '<i class="far fa-star"></i>';
    if ($avgwert >= 4.75)        echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 4.25)    echo '<i class="fas fa-star-half-alt"></i>';
    else                         echo '<i class="far fa-star"></i>';
    echo '              </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-12">
                    <h5 class="float-right">' . $anz . ' Bewertung(en)</h5>
                </div>
            </div>	
            <hr style="margin-left: 0; margin-right: 0;">
                <div class="row">
                    <div class="col-12">
                        <a href="./etablissement_details.php?etab_id=' . $id . '" class="btn btn-primary btn-block">Details</a>
                    </div>
                </div>							
            </div>
        </div>
    </div>';
};


function buildCard_cock($id, $name, $beschreibung, $img, $avgwert, $anz)
{
    echo '
    <div class="card ml-4 mr-4 mt-4 mb-4" style="width: 19rem;">';
    if ($img == null) {
        echo '
        <img src="../res/placeholder_no_image.svg" class="card-img-top" height="302" width="302">';
    } else {
        echo '
        <img src="../php/db/get_img.php?cock_id=' . $id . '" class="card-img-top" height="302" width="302">';
    }
    echo '
        <div class="card-body d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title">' . $name . '</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="card-text">' . $beschreibung . '</p>
                </div>
            </div>
            <div class="mt-auto">
                <hr style="margin-left: 0; margin-right: 0;">
                <div class="row">							
                    <div class="col-4">
                        <h5 class="rating-num float-left">' . number_format($avgwert, 1) . '</h5>
                    </div>
                    <div class="col-8">
                        <div class="rating float-right">';
    if ($avgwert >= 1)          echo '<i class="fas fa-star"></i>';
    else                        echo '<i class="far fa-star"></i>';
    if ($avgwert >= 1.75)       echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 1.25)   echo '<i class="fas fa-star-half-alt"></i>';
    else                        echo '<i class="far fa-star"></i>';
    if ($avgwert >= 2.75)       echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 2.25)   echo '<i class="fas fa-star-half-alt"></i>';
    else                        echo '<i class="far fa-star"></i>';
    if ($avgwert >= 3.75)       echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 3.25)   echo '<i class="fas fa-star-half-alt"></i>';
    else                        echo '<i class="far fa-star"></i>';
    if ($avgwert >= 4.75)       echo '<i class="fas fa-star"></i>';
    elseif ($avgwert >= 4.25)   echo '<i class="fas fa-star-half-alt"></i>';
    else                        echo '<i class="far fa-star"></i>';
    echo '              </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5 class="float-right">' . $anz . ' Bewertung(en)</h5>
                    </div>
                </div>							
                <hr style="margin-left: 0; margin-right: 0;">
                <div class="row">
                    <div class="col-12">
                        <a href="./cocktail_details.php?cock_id=' . $id . '" class="btn btn-primary btn-block">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}
