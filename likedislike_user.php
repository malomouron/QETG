<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$selectIpLikeupdate = $db->query("SELECT * FROM quiz_like_quiz WHERE id_quiz = ".$_REQUEST['q']." AND '".$_SERVER['REMOTE_ADDR']."' = ip AND likeOrDislike = ".$_REQUEST['l'])->fetchArray();
	$selectIpLike = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE id_quiz = ".$_REQUEST['q']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
	$selectQuizLiked = $db->query("select * from quiz_quiz WHERE id_quiz = '".$_REQUEST['q']."'")->fetchArray();
	if($selectQuizLiked['quizComplet'] == 1 AND count($selectQuizLiked) > 0) {
        if (isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and $selectIpLike['nbr_like_ip'] == 0) {
            $insertLikeDislikIp = $db->query("INSERT INTO quiz_like_quiz (id_like, id_quiz, ip, likeOrDislike,esQuizUser) VALUES (NULL, " . $_REQUEST['q'] . ", '" . $_SERVER['REMOTE_ADDR'] . "', " . $_REQUEST['l'] . ", 1)");
        } elseif (isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and count($selectIpLikeupdate) > 0) {
            $delet_likeOrdislike = $db->query("DELETE FROM quiz_like_quiz WHERE id_quiz = " . $_REQUEST['q'] . " AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
        } elseif (isset($_SESSION['auth']) and $_SESSION['auth'] == 1 and count($selectIpLikeupdate) == 0 and $selectIpLike['nbr_like_ip'] > 0) {
            $calcule = ($_REQUEST['l'] - 1) ** 2;
            $udate_likeOrdislike = $db->query("UPDATE quiz_like_quiz SET likeOrDislike = '" . $_REQUEST['l'] . "' WHERE id_quiz = " . $_REQUEST['q'] . " AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
        }
    }elseif (count($selectQuizLiked) == 0){
        header('Location: quiz_utilisateur.php');
    }else{
        header('Location: finirQuiz.php?q='.$_REQUEST['q']);
    }
	$_SESSION['auth'] = 0;
	include ('footer.php');
	header('Location: quiz_utilisateur.php');
?>