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
		afficher_head("Créer un utilisateur", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer un utilisateur</h1>
							<form action="action-form/creer-utilisateur-2.php" method="post" id="form" name="form1">
								<div style="margin-left: -140px;">
									<label for="nom_utilisateur">Nom de utilisateur*: </label>
									<h6 style="display: contents;">(exemple : Olam_21)</h6>
									<input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
								</div>
								<div style="margin-left: -40px;">
									<label for="mdp">Mots de pass*: </label>
									<input type="password" id="mdp" name="mdp" required>
									<img class="show-password" id="monImage" src="../commun/oeil_cache.png"/>
								</div>
								<div style="display: block;margin-left: -164px;">
									<label id="admin" style="display: inline" for="admin">Administrateur : </label>
									<input type="checkbox" id="admin" name="admin" style="display: inline;margin-right: -250px;">
								</div>
								<div class="button">
									<input type="submit" value="Envoyer" id="id-bt">
								</div>
							</form>
						</div>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
						<script type="text/javascript">
							$(document).ready(function(){
								$(\'.show-password\').click(function() {
									if($(this).prev(\'input\').prop(\'type\') == \'password\') {
										//Si c\'est un input type password
										$(this).prev(\'input\').prop(\'type\',\'text\');
										$(\'#monImage\').attr(\'src\',\'../commun/oeil.png\');
									} else {
										//Sinon
										$(this).prev(\'input\').prop(\'type\',\'password\');
										$(\'#monImage\').attr(\'src\',\'../commun/oeil_cache.png\');
									}
								});
							});
						</script>
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