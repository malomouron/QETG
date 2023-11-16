<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if (isset($_SESSION['login'])) {
		$update_fav = $db->query("UPDATE quiz_statistique SET favoris = 0 WHERE id_user = ".$_SESSION['id']." and id_quiz = ".$_REQUEST['id_quiz']);
	}
	include ('footer.php');
	header('Location: profil.php');
?>