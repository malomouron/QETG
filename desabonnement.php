<?php
	include 'functions.php';
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$delete = $db->query("UPDATE quiz_membre SET newletter = '0' WHERE quiz_membre.email = '".$_POST['mail']."'");
	include ('footer.php');
	echo 'Vous êtes désabonné des newsletters'
?>