<?php 
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if (isset($_POST['pass_supr'])) {
		$selectPasswordUser = $db->query("SELECT `pass_md5` FROM `quiz_membre` WHERE id = ".$_SESSION['id'])->fetchArray();
	}
	if (isset($_POST['pass_supr']) AND md5($_POST['pass_supr']) == $selectPasswordUser['pass_md5']) {
		$deletMembre = $db->query("DELETE FROM `quiz_membre` WHERE id = ".$_SESSION['id']);
		echo 	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Suprimer le compte", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo'			<div id="supr-compte_prof-div1">
							<h1 id="supr-compte_prof-h11">Nous avons bien réussi à suprimer votre compte</h1>
							<a id="supr-compte_prof-a1" href="deconnexion.php">cliquer ici pour pouvoir continuer à naviguer</a>
						</div>
					</body>
				</html>';
	} else {
		echo	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Suprimer le compte", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo'			<div id="supr-compte_prof-div1">
							<h1 id="supr-compte_prof-h12">Nous avons rencontré un probléme veuiller réessayer( mauvais mot de pass ?)</h1>
							<a id="supr-compte_prof-a2" href="profil.php">Retour</a>
						</div>
					</body>
				</html>';
	}
	include ('footer.php');
?>