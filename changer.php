<?php
	include ('mail.php');
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	$select_le_membre = $db->query("SELECT * FROM quiz_membre WHERE email = ?", $_POST['email'])->fetchArray();

	if (count($select_le_membre) > 0) {
		$mail->addAddress($_POST['email'], 'test'); // Ajouter le destinataire
		$mail->Subject = 'Quiz en tout genre - email de confirmation';
		
		$newpwd = Genere_Password(15);
		$message = "<html><body><div style=\"padding-bottom: 50px;background-color:#D1D1D1;\">";
		$message .= "<h1 style=\"font-family:arial,helvetica,sans-serif;font-weight:bold;font-size:50px;color:#313131;text-align:center;line-height:50px\">".$mail->Subject."</h1>";		

		$message .= "<p style=\"text-align: center\"><img src=\"".$domaine."favicon.png\" style=\"width: 13%;margin:0px;text-align:center;\"></p><br />";
			
		$message .= '<div>
						<h2 style="font-size:29px;text-align: center;color: black;">Instructions de réinitialisation de mot de passe.<h2>
						<p style="color:black;text-align:center;">Bonjour '.$select_le_membre["login"].'<br><br> Voici votre nouveau mot de pass : </p>
						<p style="text-align:center;">
							<a style="background-color:#6bae7c;padding: 15px;" href="">
								<span style="color: black;text-decoration: underline;">'.$newpwd.'</span>
							</a>
						</p>
						<p style="color:black;text-align:center;">noubliez pas que vous pouvez rechanger votre mot de pass dans votre profil</p>
						<p style="text-align:center;">
							<a href="'.$domaine.'aide-page.php">Besoin d\'aide ? </a><br>
							<p style="text-align:center;color:black;">© 2020, Quiz En Tous Genre et leurs logos respectifs sont des marques déposées de Quiz En Tous Genre. Tous droits réservés.<br></p>
							<p style="text-align:center;">
								<a href="'.$domaine.'lien-bandeau/">À propos de Quiz dans tout genre</a> | <a href="'.$domaine.'lien-bandeau/#5"">Politique de confidentialité</a>
							</p>
						</p>
					</div>';
		$message .= " </div></body></html>\r\n";

		$mail->Body = $message;
		if(!$mail->send()) {
			echo 'Erreur, message non envoyé.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
		
		echo '	<!DOCTYPE>
				<html>
					<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Mot de pass oublié", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo			'<div id="changer-div1">
							<h1 id="changer-h1">Nous vous avons envoyé un mail avec un nouveau mot de pass.</h1>
							<h4 id="changer-h4">Veuillez vous rendre sur votre adresse email et suivre les instructions dans l\'email envoyé</h4>
							<br>
							<div id="changer-div-reus">
								<p>Si vous n\'avez pas reçu de mail</p>
								<a href="javascript:window.location.reload()">Cliquez ici</a>
							</div>
							<p id="changer-p">Une fois le nouveau mot de pass récupérer vous n\'avez plus qu\'à vous connecter avec et éventuellement rechanger à nouveau de mot de pass dans votre profil.</p>
						</div>
					</body>
				</html>';
		$update_new_mdp = $db->query("UPDATE `quiz_membre` SET pass_md5 = '".md5($newpwd)."' WHERE id = ".$select_le_membre['id']);
	} else {
		echo '	<html>
				<head>';
		$css = array("mot-pass-oublier.css", "commun/bandeau.css", "css.css");
		afficher_head("Mot de pass oublié", $css, "UTF-8");
		echo'	</head>
				<body>';
		include ("bandeau.php");
		echo'		<div id="changer-div1">
						<h1>Nous n\'avons pas trouvé votre adresse email.</h1>
					</div>
				</body>
			</html>';
	}
	include ('footer.php');
?>