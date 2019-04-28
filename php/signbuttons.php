<?php
if ($angemeldet) {
    echo '<h5 class="col-auto ct-white">Hallo, <a href="../user/" class="wel-me">' . $username . '!</a></h5>';
    echo '<a href="../user/signout.php" class="btn btn-outline-light" id="abmelden" role="button" aria-pressed="true">Abmelden</a>';            
} else {
    echo '<a href="../user/signin.php" class="btn btn-outline-light" role="button" aria-pressed="true">Anmelden</a>';    
}
