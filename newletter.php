<?php
	include ('functions.php');
	include ('mail.php');	
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$select_mail_utilisateur = $db->query("SELECT * FROM quiz_membre WHERE newletter = 1")->fetchAll();
	foreach($select_mail_utilisateur as $mail_user){
		$monobjet = '- Cagnotte Paypal';
		$mail->Subject = 'Quiz en tout genre - Newsletters '.$monobjet;
		$message = "<html><body><div style=\"padding-bottom: 50px;background-color:#D1D1D1;\">";
		$message .= "<h1 style=\"font-family:arial,helvetica,sans-serif;font-weight:bold;font-size:50px;color:#313131;text-align:center;line-height:50px\">".$mail->Subject."</h1>";
		$message .= "<p style=\"text-align: center\"><img src=\"".$domaine."favicon.png\" style=\"width: 13%;margin:0px;text-align:center;\"></p><br />";
			
		$message .= '<div>
						<h2 style="font-size:29px;text-align: center;color: black;">Campagne de Don Paypal.<h2>
						<p style="color:black;text-align:center;">Bonjour '.$mail_user["login"].'<br> Soyez généreux et donnez au développeur du site</p>
						<p style="text-align:center;">
							<a style="background-color:#6bae7c;padding: 15px;" href="https://paypal.me/pools/c/8mZwKUIEdv">
								<span style="color: black;text-decoration: underline;">Faire Un Don</span>
							</a>
						</p>
						<p style="color:black;text-align:center;">N\'hésitez pas à effectuer un don pour étant donné que le serveur ait très peu de revenue</p>
						<p style="text-align:center;">
							<a href="'.$domaine.'aide-page.php">Besoin d\'aide ? </a><br>
							<p style="text-align:center;color:black;">© 2020, Quiz En Tous Genre et leurs logos respectifs sont des marques déposées de Quiz En Tous Genre. Tous droits réservés.<br></p>
							<p style="text-align:center;">
								<a href="'.$domaine.'lien-bandeau/">À propos de Quiz dans tout genre</a> | <a href="'.$domaine.'lien-bandeau.php#5"">Politique de confidentialité</a>
								<form style="text-align: center;" action="'.$domaine.'desabonnement.php" method="post">
									<input type="hidden" name="mail" value="'.$mail_user['email'].'">
									<input value="Se désabonner des newsletters" type="submit" >
								</form>
							</p>
						</p>
					</div>';
		$message .= " </div></body></html>\r\n";
		$mail->addBCC($mail_user['email']);
		$mail->addAddress('admin@malomouron.fr'); // Ajouter le destinataire
		$mail->Body = $message;
		// $mail->send();
        //echo $message;
		//echo $mail_user['email'];
	}
	
?>