<?php
	session_start();
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		include ("../commun/bandeau-admin.php");
		include ('../config.inc.php');
		
		$date_creation = date("l-d-F-Y");
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Créer un commentaire", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer un commentaire</h1>
							<form action="action-form/creer-commentaire-2.php" method="post" id="form" name="form1">
								<div style="margin-left: -35px;">
									<label for="nom">Nom*: </label>
									<input type="text" id="nom" name="nom" required>
								</div>
								<div style="margin-left: -34px;">
									<label for="prenom">Prenom*: </label>
									<input type="text" id="prenom" name="prenom" required>
								</div>
								<div style="margin-left: -184px;">
									<label for="mail">Mail*: </label>
									<h6 style="display: contents;">(exemple : exemple@gmail.com)</h6>
									<input type="email" id="mail" name="mail" required>
								</div>
								<div style="margin-left: 208px;">
									<label for="commentaire" style="display: flex;margin-left: 95px;">Message*:</label>
									<textarea id="commentaire" name="commentaire" style="margin-top: -18px;" required></textarea>
								</div>
								<div style="margin-left: 643px;border: 2px black solid;display: inline-block;">
									'.$date_creation.'
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