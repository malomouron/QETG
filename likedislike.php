<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$selectIpLikeupdate = $db->query("SELECT * FROM quiz_like_quiz WHERE id_quiz = ".$_REQUEST['q']." AND '".$_SERVER['REMOTE_ADDR']."' = ip AND likeOrDislike = ".$_REQUEST['l'])->fetchArray();
	$selectIpLike = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE id_quiz = ".$_REQUEST['q']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
	if (isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and $selectIpLike['nbr_like_ip'] == 0){
		$insertLikeDislikIp = $db->query("INSERT INTO quiz_like_quiz (id_like, id_quiz, ip, likeOrDislike) VALUES (NULL, ".$_REQUEST['q'].", '".$_SERVER['REMOTE_ADDR']."', ".$_REQUEST['l'].")");
	}elseif(isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and count($selectIpLikeupdate) > 0 ){
		$delet_likeOrdislike = $db->query("DELETE FROM quiz_like_quiz WHERE id_quiz = ".$_REQUEST['q']." AND ip = '".$_SERVER['REMOTE_ADDR']."'");
	}elseif(isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and count($selectIpLikeupdate) == 0 and $selectIpLike['nbr_like_ip'] > 0){
		$calcule = ($_REQUEST['l'] - 1)**2;
		$udate_likeOrdislike = $db->query("UPDATE quiz_like_quiz SET likeOrDislike = '".$_REQUEST['l']."' WHERE id_quiz = ".$_REQUEST['q']." AND ip = '".$_SERVER['REMOTE_ADDR']."'");
	}
	$_SESSION['auth'] = 0;
	include ('footer.php');
	header('Location: index.php');
?>