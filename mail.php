<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	$mail = new PHPmailer();

// $mail->SMTPDebug = 1;
 
	$mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
	$mail->Host = 'ssl0.ovh.net'; // Spécifier le serveur SMTP
	$mail->SMTPAuth = true; // Activer authentication SMTP
	$mail->Username = 'admin@malomouron.fr'; // Votre adresse email d'envoi
	$mail->Password = 'LAdresseCompteAdminIsBest!!2'; // Le mot de passe de cette adresse email
	$mail->SMTPSecure = 'ssl'; // Accepter SSL
	$mail->Port = 465;
	$mail->setFrom('admin@malomouron.fr', 'Quiz En Tout Genre'); // Personnaliser l'envoyeur
	$mail->addReplyTo('admin@malomouron.fr', ''); // L'adresse de réponse
	$mail->isHTML(true); // Paramétrer le format des emails en HTML ou non
	$mail->AltBody = '';
	$mail->addBCC('admin@malomouron.fr');
	
/*

	$mail->addAddress('malo.mouron@gmail.com', 'Malo Mouron'); // Ajouter le destinataire
//	$mail->addAddress('To2@example.com'); 
	$mail->addCC('fabrice.mouron@gmail.com');
	

//	$mail->addAttachment('/var/tmp/file.tar.gz'); // Ajouter un attachement
//	$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
//	$mail->isHTML(true); // Paramétrer le format des emails en HTML ou non

	$mail->Subject = 'Objet';
	$mail->Body = 'Texte du mail';
	$mail->AltBody = 'Texte au format text...';
	
	
	if(!$mail->send()) {
		echo 'Erreur, message non envoyé.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Le message a bien été envoyé !';
	}
*/
?>