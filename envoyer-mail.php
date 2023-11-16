<?php
	session_start();
    $debug = 0;
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	include ('mail.php');
	if ($_POST['g-recaptcha-response']){
		$user_name	= $_POST['user_name'];
		$user_mail	= $_POST['user_mail'];
		$user_message	= $_POST['user_message'];
		$user_prenom	= $_POST['user_prenom'];
		
		$monobjet	= "envoyez depuis l'index du site";
		$monmessage	= "
		Nom : ".$user_name."
		Prénom : ".$user_prenom."
		Email : ".$user_mail."
		Commentaire : ".$user_message;
		if (isset($user_message) && $debug == 0)
		{
			$mail->addAddress('admin@malomouron.fr'); // Ajouter le destinataire
			$mail->Subject = 'Quiz en tout genre - Commentaire '.$monobjet;
			$mail->Body = $monmessage;
		}
	
	
	echo '<!DOCTYPE html>
	<html>
		<head>';
	
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Mail Envoyé", $css, "UTF-8");
	
	echo'	</head>';
	echo'	<body>';
	include ("bandeau.php");
		echo'<div id="envoyer-mail-div1">
				<h1 id="envoyer-mail-h1">Vous avez bien créé un commentaire.</h1>
				<p id="envoyer-mail-p1">Merci monsieur/madame ';
	echo $user_prenom.' '.$user_name.' de nous avoir envoyer ce commentaire et de participer a l\'ameilioration de ce site.
					<dr>Nous allons surment vous recontacter a l\'adresse mail suivante:  ';
	echo $user_mail;
	echo'		</p>
				<a id="envoyer-mail-a1" href="index.php"> cliquez ici pour retourner à l\'écran d\'accueil</a>
			</div>
		</body>
	</html>';
	if(!isset($_SESSION['login'])){
		$user_name.= ' (Personne non verifié)';
	}
	$date_creation = dateToFrench("now" ,"l-d-F-Y");
	$insert_commentaire = $db->query("INSERT INTO quiz_commentaire(nom,prenom,mail,commentaire,date_creation,ip_utilisateur) VALUES('".securisation($user_name)."', '".securisation($user_prenom)."', '".$user_mail."', '".securisation($user_message)."', '".$date_creation."', '".$_SERVER['REMOTE_ADDR']."')");
	

		ini_set( 'display_errors', 1 );
		error_reporting( E_ALL );
		
		if(!$mail->send()) {
			echo 'Erreur, message non envoyé.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	} 
	else {
		echo '<!DOCTYPE html>
		<html>
			<head>';
		
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Commentaire-non-créer", $css, "UTF-8");
		
		echo'	</head>';
		echo'	<body>';
		include ("bandeau.php");
		echo'	<div id="envoyer-mail-div1">
					<h1 id="envoyer-mail-h1">Veuillez cocher la case "Je ne suis pas un robot" avant de publier un commentaire.</h1
					<br>
					<a id="envoyer-mail-a1" href="index.php"> cliquez ici pour retourner à l\'écran d\'accueil</a>
				</div>
			</body>
		</html>';
		}
	include ('footer.php');
?>