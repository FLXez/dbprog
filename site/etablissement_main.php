<?php
include('../php/sessioncheck.php');
$activeHead = "etablissement";

$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');
$statement = $pdo->prepare("
					SELECT 
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						ei.id,
						AVG(sub_be.wert)
					FROM etablissement e
					LEFT JOIN etablissement_img ei ON
						e.id = ei.eta_id
					LEFT JOIN 
						(
						SELECT 
							be.eta_id, 
							CAST(be.wert AS INTEGER) AS wert
						FROM
							bewertung_etablissement be
						) sub_be
					ON
						e.id = sub_be.eta_id
					GROUP BY
						e.name,
						e.ort,
						e.anschrift,
						e.verifiziert,
						ei.id");
$result = $statement->execute();
$etaFetch = $statement->fetchAll();
$etaCount = count($etaFetch);
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Etablissement - Main</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS Toolbox -->
    <link href="../css/csstoolbox.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php
        include('../php/buildHeader.php');
        ?>
    </header>
    <main role="main">
    <main role="main">
        <div class="mt-5 ml-5 mr-5">
            <div class="card card-body">
                <h2 class="ml-4">Etablissements</h2>
                <hr>
				<div class="row">
				<?php
				for ($i = 0; $i < $etaCount; $i++)
				{
					echo '
					<div class="card" style="width: 18rem;">
						<img src="../php/img.php?eta_img_id=' . $etaFetch[$i][4] . '" class="card-img-top" alt="...">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<h5 class="card-title">' . $etaFetch[$i][0] . '</h5>
								</div>
								<div class="col">';
				if ($etaFetch[$i][3] == 1)
				{
					echo '<img src="../res/verifiziert.png" height="32px" width="32px">';
				}

				echo			'</div>
								<div class="w-100"></div>
								<div class="col">
									<p class="card-text">' . $etaFetch[$i][1] . '<br>' . $etaFetch[$i][2] . '<br></p>
								</div>
								<div class="w-100"></div>
								<div class="col">
									<a href="#" class="btn btn-primary">Details</a>
								</div>
								<div class="col">
									Bewertung
								</div>
							</div>
						</div>
					</div>';
				}
				?>
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