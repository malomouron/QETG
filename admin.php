<?php 
	session_start();
	include ('functions.php');
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo	'<!DOCTYPE html>
			<html>
				<head>';
		$css = array("css.css", "commun/bandeau-admin.css");
		afficher_head("Interface administrateur", $css, "UTF-8");
		echo'	</head>
				<body>';
		include ("bandeau.php");
		echo'			<div id="admin-div1">
						<h1 id="admin-h1">Administration du site</h1>
						<div class="admin-class1">
							<fieldset id="admin-fieldset_image">
								<legend class="admin-legend">Image</legend>
								<div class="admin-div2">
									<a href="admin/creer_image.php" class="admin-lien">Ajouter une image</a>
									<a href="admin/modifier_image.php" class="admin-lien">Modifier une image</a>
								</div>
							</fieldset>
						</div>
						<div id="admin-div-quiz" class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_quiz">
								<legend class="admin-legend">Quiz</legend>
								<div class="admin-div2">
									<a href="admin/creer_quiz.php" class="admin-lien">Créer un quiz</a>
									<a href="admin/suprimer_quiz.php" class="admin-lien">Suprimer un quiz</a>
									<a href="admin/modifier_quiz.php" class="admin-lien">Modifier un quiz</a>
								</div>
							</fieldset>
						</div>
						<div class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_question">
								<legend class="admin-legend">Question</legend>
								<div class="admin-div2">
									<a href="admin/creer_question.php" class="admin-lien">Ajouter une question</a>
									<a href="admin/suprimer_question.php" class="admin-lien">Suprimer un question</a>
									<a href="admin/modifier_question.php" class="admin-lien">Modifier une question</a>
								</div>
							</fieldset>
						</div>
						<div class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_reponse">
								<legend class="admin-legend">Reponse</legend>
								<div class="admin-div2">
									<a href="admin/creer_reponse.php" class="admin-lien">Ajouter une reponse</a>
									<a href="admin/suprimer_reponse.php" class="admin-lien">Suprimer un reponse</a>
									<a href="admin/modifier_reponse.php" class="admin-lien">Modifier une reponse</a>
								</div>
							</fieldset>
						</div>
						<div class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_utilisateur">
								<legend class="admin-legend">Utilisateur</legend>
								<div class="admin-div2">
									<a href="admin/creer_utilisateur.php" class="admin-lien">Créer un utilisateur</a>
									<a href="admin/suprimer_utilisateur.php" class="admin-lien">Suprimer un utilisateur</a>
									<a href="admin/modifier_utilisateur.php" class="admin-lien">Modifier un utilisateur</a>
								</div>
							</fieldset>
						</div>
						<div class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_statistique">
								<legend class="admin-legend">Statistique</legend>
								<div class="admin-div2">
									<a href="admin/creer_statistique.php" class="admin-lien">Ajouter un statistique</a>
									<a href="admin/suprimer_statistique.php" class="admin-lien">Suprimer un statistique</a>
									<a href="admin/modifier_statistique.php" class="admin-lien">Modifier un statistique</a>
								</div>
							</fieldset>
						</div>
						<div class="admin-class1">
							<br><br><br><br><br><br>
							<fieldset id="admin-fieldset_commentaire">
								<legend class="admin-legend">Commentaire</legend>
								<div class="admin-div2">
									<a href="admin/creer_commentaire.php" class="admin-lien">Ajouter un commantaire</a>
									<a href="admin/suprimer_commentaire.php" class="admin-lien">Suprimer un commantaire</a>
									<a href="admin/modifier_commentaire.php" class="admin-lien">Modifier un commantaire</a>
								</div>
							</fieldset>
						</div>
					</div>
				</body>
			</html>';
	} elseif (isset($_SESSION['login']) && $_SESSION['admin'] == 0){
		echo 'Accés Interdi';
	} else {
		if (!isset($_SESSION['login'])){
			echo 'Connectez-vous pour avoir accés a cette page';
		}
	}
?>