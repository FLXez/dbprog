<?php

function buildMarketing($etab_id, $etab_name, $etab_img, $bew_id, $bew_name, $bew_text)
{
    if ($etab_img) {
        echo '<img src="../php/db/get_img.php?etab_id=' . $etab_id . '" class="rounded-circle" height="200px" width="200px">';
    } else {
        echo '<img src="../res/placeholder_no_image.svg" class="rounded-circle" height="200px" width="200px">';
    }
    echo '
    <h2>' . $etab_name . '</h2>
    <p>' . $bew_text . ' <br>(von <a class="" href="../site/profil_other.php?showUser=' . $bew_id . '">' . $bew_name . '</a>)</p>
    <p><a class="btn btn-primary" href="./etablissement_details.php?etab_id=' . $etab_id . '" role="button">Weitere Informationen &raquo;</a></p>';
}
