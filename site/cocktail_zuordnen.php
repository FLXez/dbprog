<?php
include('../php/sessioncheck.php');
//activeHead setzen.
$activeHead = "Cocktails";
$_SESSION['source']= "Location: ../site/cocktail_zuordnen.php";



$pdo = new PDO('mysql:host=localhost;dbname=dbprog', 'root', '');

	$statement = $pdo-> prepare("SELECT name FROM cocktail WHERE id =:cockid");
	$result = $statement->execute(array('cockid'=> $_GET["chosenCocktail"] ));
	$cockDaten = $statement->fetch();

	$statementEtabs = $pdo->prepare("SELECT e.id,
												e.name,
												e.ort
										FROM etablissement e RIGHT JOIN  cocktailkarte c ON e.id = c.eta_id WHERE NOT cock_id = :cockid");
		$etabResult = $statementEtabs->execute();
		$allEtabsPos = $statementEtabs->fetchAll();


?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Felix Pause, Cedrick Bargel, Philipp Potraz">
    <title>Hameln E&C</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome (icons) -->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <!-- CSS Toolbox -->
    <link href="../../css/csstoolbox.css" rel="stylesheet">
</head>

<body>
    <header role="header">
        <?php
        include('../php/buildHeader.php');
        ?>
    </header>
    <main role="main">
			<?php echo'
        <div class="mt-5 ml-5 mr-5">
            <div class="card card-body">
                <h2 class="ml-4">  ' . $cockDaten[0] . '  einem Etablissement zuordnen:</h2>
                <hr>
                <div class="ml-5 mr-5 mt-2">
				
				<div class="form-group">
							<label for="etab"> Etablissement Zuordnen</label>
							<select class="custom-select" name="etab" id="etab">';
							for($i = 0; $i <count($allEtabsPos); $i++){
								echo '<option value="' . $allEtabsPos[$i][0] .'">'. $allEtabsPos[$i][1] .', ' . $allEtabsPos[$i][2] . '</option>';
							}
							echo '</select>
						</div>

						<button type="submit" class="btn btn-primary">Erstellen</button>
                </div>
            </div>
        </div>'
		?>
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