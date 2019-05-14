<?php
include('../php/sessioncheck.php');
$activeHead = "uberUns";
$_SESSION['source'] = "Location: ../site/about_team.php";
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <link rel="shortcut icon" type="image/x-icon" href="../res/favicon.ico">
    <title>Über Uns - Team</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS Toolbox -->
    <link href="../css/csstoolbox.css" rel="stylesheet">
</head>

<body>
    <header role="header">
        <?php
        include('../php/buildHeader.php');
        ?>
    </header>
    <main role="main">
        <main role="main">
            <div class="mt-5 ml-5 mr-5">
                <div class="card card-body">
                    <h2 class="ml-2">Das Team</h2>
                    <hr>
                    <div class="ml-2 mr-2 mt-2">
                        <div>
                            Das Team hat kein Bock auf diese Seite. Mach sie dir doch selber.<br>
                            <br>
                            Nein Spaß Bruder, das Team besteht aus mir, dem Esel, ave mir.<br>
                        </div>
                        <div style="text-align: center;">
                            Ich sehe mich schon ziemlich zentral, wo auch sonst.<br>
                        </div>
                        <div>
                            Des weiteren haben wir Felix Pause. <br>
                            Ja, wir haben trotzdem einiges geschafft, obwohl die Kommunikation mit einem derart altem Dinosaurier aus der Cobold eh Cobol Umgebung sich als schwierig erweist.<br>
                        </div>
                        <br>
                        <div>
                            Aber wir hatten auch himmlischen Segen, schließlich ist Jesus unser Head-Entwickler.<br>
                            Freaking Jesus Folks.<br>
                        </div>
                        <div style="text-align: center;">
                            Achja, und mich. Natürlich. Jeder weiß, wer ich bin.
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>