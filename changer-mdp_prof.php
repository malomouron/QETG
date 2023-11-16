<?php 
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if ($_POST['pass'] == $_POST['pass_confirm'] && isset($_POST['pass'])) {
		$update_mdp_par_user = $db->query("UPDATE `quiz_membre` SET `pass_md5` = '".md5($_POST['pass'])."' WHERE id = ".$_SESSION['id']);
		echo 	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Changer de mot de pass", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo'			<div id="changer-mdp_prof-div1">
							<h1 id="changer-mdp_prof-h11">Nous avons bien réussi à changer votre mot de pass</h1>
						</div>
					</body>
				</html>';
	} else {
		echo	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Changer de mot de pass", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo'			<div id="changer-mdp_prof-div1">
							<h1 id="changer-mdp_prof-h12">Nous avons rencontré un probléme veuiller réessayer</h1>
						</div>
					</body>
				</html>';
	}
	include ('footer.php');
?>