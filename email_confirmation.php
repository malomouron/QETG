<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$key_password = "Mal0_av3c_Une_Cle_hyper_S3cure!z";
	$decrypted_chaine = openssl_decrypt($_POST['key'], "AES-128-ECB" , $key_password);
	
	if ($_POST['g-recaptcha-response']){
		if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') {
			if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass'])) && (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm'])) && (isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['email']) && !empty($_POST['email']))) {
				if ($_POST['pass'] != $_POST['pass_confirm']) {
					$_SESSION['erreur'] = 'Les 2 mots de passe sont différents.';
					$_SESSION['debug'] = 1;
					header('Location: inscription.php');
				} else {
					$select_connecton_avant_insr = $db->query('SELECT * FROM quiz_membre WHERE login="'.$_POST['login'].'"')->fetchArray();
					$select_connecton_avant_insr_cle = $db->query('SELECT * FROM quiz_cle WHERE cle_login="'.$_POST['login'].'" and cle != "'.$decrypted_chaine.'"')->fetchArray();
					if (count($select_connecton_avant_insr) == 0 AND count($select_connecton_avant_insr_cle) == 0) {
						$select_connecton_avant_avant_insr = $db->query('SELECT * FROM quiz_membre WHERE email="'.$_POST['email'].'"')->fetchArray();
						$select_connecton_avant_avant_insr_cle = $db->query('SELECT * FROM quiz_cle WHERE cle_email="'.$_POST['email'].'" and cle != "'.$decrypted_chaine.'"')->fetchArray();
						if(count($select_connecton_avant_avant_insr) == 0 AND count($select_connecton_avant_avant_insr_cle) == 0){
							include ('mail.php');
							$select_cle_identique = $db->query("SELECT * FROM quiz_cle where cle = '".$decrypted_chaine."'")->fetchArray();
							$date = date("Y-m-d");
							if(count($select_cle_identique) == 0){
								if ($_POST['newletter'] == 1){
									$insert_cle = $db->query("INSERT INTO quiz_cle (id_cle, cle, cle_login, cle_pass_md5, cle_email, cle_nom, cle_prenom, cle_newletter,cle_date) VALUES (NULL, '".$decrypted_chaine."', '".securisation($_POST['login'])."', '".md5($_POST['pass'])."', '".securisation($_POST['email'])."', '".securisation($_POST['nom'])."', '".securisation($_POST['prenom'])."', ".$_POST['newletter'].", '".$date."')");
								}else {
									$insert_cle = $db->query("INSERT INTO quiz_cle (id_cle, cle, cle_login, cle_pass_md5, cle_email, cle_nom, cle_prenom,cle_date) VALUES (NULL, '".$decrypted_chaine."', '".securisation($_POST['login'])."', '".md5($_POST['pass'])."', '".securisation($_POST['email'])."', '".securisation($_POST['nom'])."', '".securisation($_POST['prenom'])."', '".$date."')");
								}
							}
							$mail->addAddress($_POST['email']);
							$mail->Subject = 'Quiz en tout genre - Email De Confirmation';
							$message = "<html><body><div style=\"padding-bottom: 50px;background-color:#D1D1D1;\">";
							$message .= "<h1 style=\"font-family:arial,helvetica,sans-serif;font-weight:bold;font-size:50px;color:#313131;text-align:center;line-height:50px\">".$mail->Subject."</h1>";
							$message .= "<p style=\"text-align: center\"><img src=\"".$domaine."favicon.png\" style=\"width: 13%;margin:0px;text-align:center;\"></p><br />";
							$message .= '<div>
											<h2 style="font-size:29px;text-align: center;color: black;">Email de confirmation pour une inscription.<h2>
											<p style="color:black;text-align:center;">Bonjour '.$_POST['login'].'<br> Veuillez cliquer sur le lien pour confirmer l\'inscription au site</p>
											<p style="text-align:center;">
												<a style="background-color:#7451eb;padding: 15px;" href="'.$domaine.'confirmation.php?k='.$decrypted_chaine.'&v=o">
													<span style="color: black;text-decoration: underline;">Confirmation</span>
												</a>
											</p>
											<p style="color:black;text-align:center;">Si ce n\'est pas vous qui vous êtes inscrit merci de le signaler et de cliquer <a style="color:red;" href="'.$domaine.'confirmation.php?k='.$decrypted_chaine.'&v=n">ici</a></p>
											<p style="text-align:center;">
												<a href="'.$domaine.'aide-page.php">Besoin d\'aide ? </a><br>
												<p style="text-align:center;color:black;">© 2020, Quiz En Tous Genre et leurs logos respectifs sont des marques déposées de Quiz En Tous Genre. Tous droits réservés.<br></p>
												<p style="text-align:center;">
													<a href="'.$domaine.'lien-bandeau/">À propos de Quiz dans tout genre</a> | <a href="'.$domaine.'lien-bandeau.php#5"">Politique de confidentialité</a>
												</p>
											</p>
										</div>';
							$message .= " </div></body></html>\r\n";
							$mail->Body = $message;
							$mail->send();
							echo '  <!DOCTYPE html>
									<html>
										<head>';
							$css = array("css.css", "commun/bandeau.css");
							afficher_head("Inscription", $css, "UTF-8");
							echo'</head>
										<body>';
							include ('bandeau.php');
							echo'			<div class="email_confirmation" id="div1">
												<h1>Nous vous avons envoyé un mail de confirmation merci de consulter votre boîte mail à l\'adresse suivante '.$_POST['email'].'</h1>
												<div id="changer-div-reus">
													<p>Si vous n\'avez pas reçu de mail</p>
													<a href="javascript:window.location.reload()">Cliquez ici</a>
												</div>
												<br><br><br><br><br>
											</div>
										</body>
									</html>';
							}else{
								$_SESSION['erreur'] = 'Un membre possède déjà cette adresse email.';
								$_SESSION['debug'] = 1;
								header('Location: inscription.php');
							}
						}else {
							$_SESSION['erreur'] = 'Un membre possède déjà ce login.';
							$_SESSION['debug'] = 1;
							header('Location: inscription.php');
						}
					} 
				}else {
					$_SESSION['erreur'] = 'Au moins un des champs est vide.';
					$_SESSION['debug'] = 1;
					header('Location: inscription.php');
				}
			}
		}else{
			$_SESSION['erreur'] = 'Remplir le reCapcha';
			$_SESSION['debug'] = 1;
			header('Location: inscription.php');
		}
?>