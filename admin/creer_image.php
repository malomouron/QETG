<?php
	session_start();
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		include ("../commun/bandeau-admin.php");
		include ('../config.inc.php');
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Créer une image", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer une image</h1>
							<form action="action-form/creer-image-2.php" method="post" id="form">
								<div style="margin-left: -85px;">
									<label for="src">Chemin vers l\'image*: </label>
									<h6 style="display: contents;">(exemple : commun/image-quiz-php.png)</h6>
									<input type="text" id="src" name="src" required>
								</div>
								<div style="margin-left: -150px;">
									<label for="alt">Description de l\'image*: </label>
									<h6 style="display: contents;">(exemple : image représentent le logo du quiz dhistoire)</h6>
									<input type="text" id="src" name="src" required>
								</div>
								<div class="button">
									<input type="submit" value="Envoyer" id="id-bt">
								</div>
							</form>
						</div>
					</body>
				</html>';
	} elseif (isset($_SESSION['login']) && $_SESSION['admin'] == 0){
		echo 'Accés Interdi';
	} else {
		if (!isset($_SESSION['login'])){
			echo 'Conectez vous pour avoir accés a cette page';
		}
	}
?>