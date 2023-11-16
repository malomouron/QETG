<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if(isset($_SESSION['id'])){
		if(isset($_REQUEST['b'])){
			$selectDejaAbonne = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$_REQUEST['a'])->fetchArray();
			if(count($selectDejaAbonne) > 0){
				$insertAbonnement = $db->query("DELETE FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$_REQUEST['a']);
			}
		}else{
			$selectDejaAbonne = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$_REQUEST['a'])->fetchArray();
			if(count($selectDejaAbonne) == 0){
				$insertAbonnement = $db->query("INSERT INTO quiz_subscription_membre (idAbonnement, idUser, idUserAbonnement) VALUES (NULL, '".$_SESSION['id']."', '".$_REQUEST['a']."')");
			}
		}
	}
	include ('footer.php');
	if (isset($_GET['b'])){
        header('Location: quiz_utilisateur.php?defaultOnglet=');
    }else{
        header('Location: quiz_utilisateur.php?defaultOnglet2=');
    }

?>