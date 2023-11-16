<?php
	include 'functions.php';
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$delete = $db->query("DELETE FROM quiz_cle WHERE cle_date < adddate(now(),-1)");
	include 'footer.php';
?>