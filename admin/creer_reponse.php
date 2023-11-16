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
		afficher_head("Créer une reponse", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer une reponse</h1>
							<h2 style="font-size:20px;color:red;">Ajouter une question avant de créer une reponse!</h2>
							<h2 style="font-size:20px;color:red;">Créer un quiz avant de créer un reponse!</h2>
							<form action="creer_reponse-2.php" method="get" id="form" name="form1">
								<div style="display: block;margin-left: -117px;">
									<label for="nombre_reponse">Combien voulez vous de reponse*: </label>
									<select name="nombre_reponse">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
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