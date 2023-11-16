<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$select_la_cle = $db->query("SELECT * FROM quiz_cle where cle = '".$_REQUEST['k']."'")->fetchArray();
	if(count($select_la_cle) > 1 && $_REQUEST['v'] == "o"){
		$insert_membre = $db->query('INSERT INTO quiz_membre (login,pass_md5,email,nom,prenom,newletter,ip,date) VALUES ("'.$select_la_cle['cle_login'].'", "'.$select_la_cle['cle_pass_md5'].'", "'.$select_la_cle['cle_email'].'", "'.$select_la_cle['cle_nom'].'", "'.$select_la_cle['cle_prenom'].'", "'.$select_la_cle['cle_newletter'].'", "'.$_SERVER['REMOTE_ADDR'].'", "'.date("d/m/Y").'")');
		$select_apres_insertion = $db->query("SELECT * FROM quiz_membre where login = '".$select_la_cle['cle_login']."'")->fetchArray();
		$_SESSION['login'] = $select_apres_insertion['login'];
		$_SESSION['id'] = $select_apres_insertion["id"];
		$_SESSION['admin'] = $select_apres_insertion["admin"];
		$delet_inutile = $db->query("DELETE FROM quiz_cle WHERE cle = '".$_REQUEST['k']."'");
        $newSucces = $db->query("INSERT INTO `quiz_membre_succes` (`id_membre_succes`, `id_succes`, `id_membre`, `date_succes`) VALUES (NULL, 4, ".$select_apres_insertion["id"].", '".date("d/m/Y")."')");
		include ('footer.php');
		header('Location: index.php');
		exit();
	}elseif($_REQUEST['v'] == "n"){
		$delet_mauvais_mail = $db->query("DELETE FROM quiz_cle WHERE cle = '".$_REQUEST['k']."'");
		include ('footer.php');
		$_SESSION['erreur'] = 'Merci de nous avoir signalé que ce n\'était pas votre adresse email, vous pouvez continuer de naviguer sur notre site si vous le désirez';
		$_SESSION['debug'] = 1;
		header('Location: inscription.php');
	}else{
		$_SESSION['erreur'] = 'Mauvais mail ou votre cle n\'exisete pas dans notre base de donné';
		$_SESSION['debug'] = 1;
		$delet_mauvais_mail = $db->query("DELETE FROM quiz_cle WHERE cle = '".$_REQUEST['k']."'");
		include ('footer.php');
		header('Location: inscription.php');
	}
?>