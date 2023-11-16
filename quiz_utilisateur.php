<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="commun/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="commun/slick/slick-theme.css"/>
<?php
	$_SESSION['auth'] = 1;
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Quiz utilisateur", $css, "UTF-8");
?>
    </head>
    <body>
<?php
	include ('bandeau.php');
	$selete_all_quiz_user = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND quiz.portee = 1 AND quiz_membre.id = quiz.id_user")->fetchAll();
?>
			<div id="poster_quiz-menu-gauche"></div>
			<div id="poster_quiz-div1">
			<div class="tab">
				<button class="tablinks" onclick="openCity(event, 'quiz_user')" id="defaultOpen">Quiz des utilisateur</button>
<?php
	if(isset($_SESSION['login'])){
			echo'<button class="tablinks" id="mes_quiz_opcity" onclick="openCity(event, \'mes_quiz\')">Mes quiz</button>';
	}
?>
				<button class="tablinks" onclick="openCity(event, 'Classement')">Classement</button>
<?php
	if(isset($_SESSION['login'])){
		echo	'<button class="tablinks" onclick="openCity(event, \'mes_like\')">Mes quiz liker</button>
				<button class="tablinks" id="defaultOnglet" onclick="openCity(event, \'compte_suivi\')">Compte suivie</button>
				<button class="tablinks" id="ajtMembre" onclick="openCity(event, \'ajtMembre2\');document.getElementsByClassName(\'slick-next\')[0].click();">Ajouter un membre</button>';
	}
?>
			</div>
			<div id="quiz_user" class="tabcontent">
				<form id="modif_for_rech_quiz_user_all_quiz" class="search-form" action="quiz_utilisateur.php" method="get">
					<div class="search-div-rchrch">
						<label class="search-label" for="s"></label>
						<input class="search-input" type="text" name="s" placeholder="Recherche..." autocomplete="off" value="">
						<svg class="search-svg" viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
						</svg>
					</div>
                    <label>Rechercher par id (Si le quiz à un statue privé)</label><input type="checkbox" name="rech_by_id">
				</form>
<?php
	if(isset($_REQUEST['s'])){
	    if ($_GET['rech_by_id'] == "on" AND settype($_REQUEST['s'], "integer")){
            $selete_recherches_quizs_user = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND id_quiz = ".$_REQUEST['s']." AND quiz_membre.id = quiz.id_user")->fetchAll();
        }else{
            $selete_recherches_quizs_user = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND ( nom_quiz LIKE '%".$_REQUEST['s']."%' ) AND quiz.portee = 1 AND quiz_membre.id = quiz.id_user")->fetchAll();
        }
        if(count($selete_recherches_quizs_user) > 0){
			foreach($selete_recherches_quizs_user as $selete_recherche_quiz_user){
			$slect_nbr_like_quiz = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_recherche_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_dis_quiz = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_recherche_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_like_quiz_user = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_recherche_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			$slect_nbr_dis_quiz_user = $db->query("SELECT count(*) nbr_dis_ip FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_recherche_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			
				echo '<div id="search-div">
					<a href="makeQuiz.php?id_quiz='.$selete_recherche_quiz_user['id_quiz'].'">
						<img id="search-img-pre" src="/quiz'.$selete_recherche_quiz_user['src'].'">
						<div id="search-div-img">
							<h2 id="search-h2">'.$selete_recherche_quiz_user['nom_quiz'].'</h2>
							<span class="span_id_user_par">Fait par '.$selete_recherche_quiz_user['login'].'</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>
					'.$slect_nbr_like_quiz['nbr_like'].'
					<a href="likedislike_user.php?l=1&q='.$selete_recherche_quiz_user['id_quiz'].'">
						<svg ';
					if($slect_nbr_like_quiz_user['nbr_like_ip'] > 0){
						echo 'style="fill: blue;"';
					}
					echo' class="index-svg-like" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
					</a>
					'.$slect_nbr_dis_quiz['nbr_dis'].'
					<a href="likedislike_user.php?l=0&q='.$selete_recherche_quiz_user['id_quiz'].'">
						<svg ';
					if($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0){
						echo 'style="fill: red;"';
					}
					echo ' class="index-svg-dislike" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
					</a>
					<span>'.$selete_recherche_quiz_user['vue'].' Vue</span>
				</div>';
			}
		}else{
			echo 'Aucun quiz trouver';
		}
	}else{
		foreach($selete_all_quiz_user as $quiz_user){
			$slect_nbr_like_quiz = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_dis_quiz = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_like_quiz_user = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			$slect_nbr_dis_quiz_user = $db->query("SELECT count(*) nbr_dis_ip FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			
			echo '<div id="search-div">
					<a href="makeQuiz.php?id_quiz='.$quiz_user['id_quiz'].'">
						<img id="search-img-pre" src="/quiz'.$quiz_user['src'].'">
						<div id="search-div-img">
							<h2 id="search-h2">'.$quiz_user['nom_quiz'].'</h2>
							<span class="span_id_user_par">Fait par '.$quiz_user['login'].'</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>
					'.$slect_nbr_like_quiz['nbr_like'].'
					<a href="likedislike_user.php?l=1&q='.$quiz_user['id_quiz'].'">
						<svg ';
					if($slect_nbr_like_quiz_user['nbr_like_ip'] > 0){
						echo 'style="fill: blue;"';
					}
					echo' class="index-svg-like" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
					</a>
					'.$slect_nbr_dis_quiz['nbr_dis'].'
					<a href="likedislike_user.php?l=0&q='.$quiz_user['id_quiz'].'">
						<svg ';
					if($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0){
						echo 'style="fill: red;"';
					}
					echo ' class="index-svg-dislike" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
					</a>
					<span class="decalage_span_vue">'.$quiz_user['vue'].' Vues</span>
				</div>';
		}
	}
?>
			</div>
<?php
	if(isset($_SESSION['login'])){
		echo'	<div id="mes_quiz" class="tabcontent">';
		$selete_mes_quiz_user = $db->query("SELECT * FROM quiz WHERE id_quiz_user = 1 AND id_user = ".$_SESSION['id'])->fetchAll();
		foreach($selete_mes_quiz_user as $selete_le_quiz_user){
			$slect_nbr_like_quiz = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_dis_quiz = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_like_quiz_user = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			$slect_nbr_dis_quiz_user = $db->query("SELECT count(*) nbr_dis_ip FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			if($selete_le_quiz_user['quizComplet'] == 1) {
                echo '<div id="search-div">
					<a href="makeQuiz.php?id_quiz=' . $selete_le_quiz_user['id_quiz'] . '">
						<img id="search-img-pre" src="/quiz' . $selete_le_quiz_user['src'] . '">
						<div id="search-div-img">
							<h2 id="search-h2">' . $selete_le_quiz_user['nom_quiz'] . '</h2>
							<span class="span_id_user_par">Fait par ' . $_SESSION['login'] . '</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>
					<table id="table_mes_quiz_quiz_user">
					    <tr>
                            <td id="mes_quiz_quiz_user_like_td">
                            ' . $slect_nbr_like_quiz['nbr_like'] . '
					            <a href="likedislike_user.php?l=1&q=' . $selete_le_quiz_user['id_quiz'] . '">
						            <svg ';
                if ($slect_nbr_like_quiz_user['nbr_like_ip'] > 0) {
                    echo 'style="fill: blue;"';
                }
                echo ' class="index-svg-like_bis" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
					            </a>
                            </td>
                            <td>
                                <a href="deleteQuiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                                    <img class="poubelleIdImg" src="commun/trash.png" alt="poubelle ">
                                </a>
                                <a href="poster_quiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                                    <img class="crayonIdImg" src="commun/crayon.png" alt="crayon ">
                                </a>
                            </td>
                        </tr>
					    <tr>
                            <td>
                            ' . $slect_nbr_dis_quiz['nbr_dis'] . '
                                <a href="likedislike_user.php?l=0&q=' . $selete_le_quiz_user['id_quiz'] . '">
                                    <svg ';
                if ($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0) {
                    echo 'style="fill: red;"';
                }
                echo ' class="index-svg-like_bis" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
					            </a>
                            </td>
                            <td>
                            <span onclick="copy('.$selete_le_quiz_user['id_quiz'].');">
                                <img class="shareIdImg" src="commun/share.png" alt="partager">
                            </span>
                            </td>
                        </tr>
                    </table>
				</div><br>';
            }elseif($selete_le_quiz_user['quizComplet'] == 0){

                $lienFinirQuiz = boutonFinirQuiz($selete_le_quiz_user['id_quiz'], $selete_le_quiz_user, $db);
                echo '<div id="search-div">
                        <a href="' .$lienFinirQuiz.'">
                            <img id="search-img-pre" src="/quiz' . $selete_le_quiz_user['src'] . '">
                            <div id="search-div-img">
                                <h2 id="search-h2">' . $selete_le_quiz_user['nom_quiz'] . '</h2>
                                <span class="span_id_user_par">Fait par ' . $_SESSION['login'] . '</span>
                                 <span class="span_id_user_par">Cliquez ici pour poster votre quiz</span>
                            </div>
                        </a>
                        <a href="deleteQuiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                            <img class="poubelleIdImg" src="commun/trash.png" alt="poubelle ">
                        </a>
				       </div>';
            }
		}
		if(count($selete_mes_quiz_user) == 0){
			echo 'Vous n\'avez pas publié de quiz<br>
			<a href="poster_quiz.php">Poster en un</a>';
		}
		echo'</div>';
	}
?>
			<div id="Classement" class="tabcontent">
<?php
	$selete_all_quiz_user_classement = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND quiz.portee = 1 AND quiz_membre.id = quiz.id_user")->fetchAll();
	foreach($selete_all_quiz_user_classement as $quiz_user_classement){
		$slect_nbr_like_quiz_classement = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$quiz_user_classement['id_quiz'])->fetchArray();
		$slect_nbr_dis_quiz_classement = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$quiz_user_classement['id_quiz'])->fetchArray();
		$valeur_pour_classement = $slect_nbr_like_quiz_classement['nbr_like'] - $slect_nbr_dis_quiz_classement['nbr_dis'];
		$tableau_classement[] = array('like' => $valeur_pour_classement, 'id_quiz' => $quiz_user_classement['id_quiz']);
	}
	$columns = array_column($tableau_classement, 'like');
	array_multisort($columns, SORT_DESC, $tableau_classement);

    $selete_all_quiz_user_classement_2 = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND quiz.portee = 1 AND quiz_membre.id = quiz.id_user")->fetchAll();
    foreach($selete_all_quiz_user_classement_2 as $quiz_user_classement_2){
        $valeur_pour_classement_2 = $quiz_user_classement_2['vue'];;
        $tableau_classement_2[] = array('vue' => $valeur_pour_classement_2, 'id_quiz' => $quiz_user_classement_2['id_quiz']);
    }
    $columns_2 = array_column($tableau_classement_2, 'vue');
    array_multisort($columns_2, SORT_DESC, $tableau_classement_2);



    $compteur = 1;
	echo '<table id="quiz_user_table_1_class" class="tftable" border="1">
			<tr><th colspan="5">Classement des quiz avec le plus de like</th></tr>
			<tr><th class="th_classement">Place</th><th class="th_classement" colspan="2">Nom du quiz</th><th class="th_classement">Nombre de like</th><th class="th_classement">Propriétaire</th></tr>';
	foreach($tableau_classement as $quiz_classe){
		$slect_nbr_dis_quiz_classement = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND id_quiz = ".$quiz_classe['id_quiz']." AND id_user = id")->fetchArray();
		if ($quiz_classe['like'] < 0){
			$nbr_like_dislike = abs($quiz_classe['like'])." dislike";
		}else{
			$nbr_like_dislike = $quiz_classe['like']." like";
		}
		echo '<tr><td class="th_classement">'.$compteur.'</td><td class="th_classement"><a class="moon_lien_quie_class" href="makeQuiz.php?id_quiz='.$quiz_classe['id_quiz'].'">'.$slect_nbr_dis_quiz_classement['nom_quiz'].'</a></td><td><img id="img-classement" class="th_classement" src="/quiz'.$slect_nbr_dis_quiz_classement['src'].'"></td><td class="th_classement">'.$nbr_like_dislike.'</td><td class="th_classement"><a class="moon_lien_quie_class" href="profil.php?u='.$slect_nbr_dis_quiz_classement['id'].'">'.$slect_nbr_dis_quiz_classement['login'].'</a></td></tr>';
		$compteur++;
	}
	echo '</table>';

    $compteur = 1;
    echo '<table class="tftable" border="1">
                <tr><th colspan="5">Classement des quiz avec le plus de vues</th></tr>
                <tr><th class="th_classement">Place</th><th class="th_classement" colspan="2">Nom du quiz</th><th class="th_classement">Nombre de vue</th><th class="th_classement">Propriétaire</th></tr>';
    foreach($tableau_classement_2 as $quiz_classe){
        $slect_nbr_vue_quiz_classement = $db->query("SELECT * FROM quiz, quiz_membre WHERE quizComplet = 1 AND  id_quiz_user = 1 AND id_quiz = ".$quiz_classe['id_quiz']." AND id_user = id")->fetchArray();
        $nbr_vue = abs($quiz_classe['vue'])." vues";
        echo '<tr><td class="th_classement">'.$compteur.'</td><td class="th_classement"><a class="moon_lien_quie_class"  href="makeQuiz.php?id_quiz='.$quiz_classe['id_quiz'].'">'.$slect_nbr_vue_quiz_classement['nom_quiz'].'</a></td><td><img id="img-classement" class="th_classement" src="/quiz'.$slect_nbr_vue_quiz_classement['src'].'"></td><td class="th_classement">'.$nbr_vue.'</td><td class="th_classement"><a class="moon_lien_quie_class" href="profil.php?u='.$slect_nbr_vue_quiz_classement['id'].'">'.$slect_nbr_vue_quiz_classement['login'].'</a></td></tr>';
        $compteur++;
    }
    echo '</table>';

?>
			</div>
<?php
	if(isset($_SESSION['login'])){
		$select_all_like_ip = $db->query("SELECT * FROM quiz_like_quiz, quiz WHERE quizComplet = 1 AND  quiz.id_quiz_user = 1 AND quiz.id_quiz = quiz_like_quiz.id_quiz AND ip = '".$_SERVER['REMOTE_ADDR']."' AND likeOrDislike = 1")->fetchAll();
		echo	'<div id="mes_like" class="tabcontent">';
		foreach($select_all_like_ip as $select_like_ip){
			echo '	<a href="makeQuiz.php?id_quiz='.$select_like_ip['id_quiz'].'">
						<img id="search-img-pre" src="/quiz'.$select_like_ip['src'].'">
						<div id="search-div-img">
							<h2 id="search-h2">'.$select_like_ip['nom_quiz'].'</h2>
							<span class="span_id_user_par">Fait par '.$_SESSION['login'].'</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>';
		}
		if (count($select_all_like_ip) == 0){
			echo 'Vous n\'avez pas likez de quiz';
		}
		echo'	</div>
				<div id="compte_suivi" class="tabcontent">
				<form class="search-form" action="quiz_utilisateur.php" method="get">
					<div class="search-div-rchrch">
					<input type="hidden" name="defaultOnglet" value="">
						<label class="search-label" for="a"></label>
						<input class="search-input" type="text" name="a" placeholder="Rechercher un membre à qui vous êtes abonné" autocomplete="off" value="">
						<svg class="search-svg" viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
						</svg>
					</div>
				</form>';
		
		if(isset($_REQUEST['a'])){
			$selectAbonnementMembreRechercher = $db->query("SELECT * FROM quiz_subscription_membre, quiz_membre WHERE id = idUserAbonnement AND idUser = ".$_SESSION['id']." AND login LIKE '%".$_REQUEST['a']."%'")->fetchAll();
			echo '<span id="quiz_utilisateur-span-ajt" onClick="document.getElementById(\'ajtMembre\').click();"><img class="quiz_utilisateur-img-ajt" src="commun/ajt.png">Ajouter un membre</span><br><br>';
			if(count($selectAbonnementMembreRechercher) > 0){
				foreach($selectAbonnementMembreRechercher as $seleteRechercheUser){
					if(isset($_SESSION['id'])){
						$selectDejaAbonner = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$seleteRechercheUser['id'])->fetchArray();
						if(count($selectDejaAbonner) > 0){
							if($seleteRechercheUser['image_profil'] != 'default'){
								echo '	<div class="quiz_utilisateur-div-profil">
	                                        <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$seleteRechercheUser['id'].'">
                                                <img class="quiz_utilisateur-img-profil"  src="'.$seleteRechercheUser['image_profil'].'">
                                                <span>'.$seleteRechercheUser['login'].'</span>
                                            </a>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$seleteRechercheUser['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
										</div>';
							}else{
								echo '	<div class="quiz_utilisateur-div-profil">
	                                        <a class="quiz_utilisateur-class-a-profil" href="profil.php?u='.$seleteRechercheUser['id'].'">
                                                <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
                                                <span>'.$seleteRechercheUser['login'].'</span>
											</a>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$seleteRechercheUser['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
										</div>';
							}
						}
					}
				}
			}else{
				echo 'Aucun résultat';
			}
		}else{
			$select_all_abonnement_membre = $db->query("SELECT * FROM quiz_subscription_membre, quiz_membre WHERE idUser = ".$_SESSION['id']." AND quiz_membre.id = quiz_subscription_membre.idUserAbonnement")->fetchAll();
			echo '<span id="quiz_utilisateur-span-ajt" onClick="document.getElementById(\'ajtMembre\').click();"><img class="quiz_utilisateur-img-ajt" src="commun/ajt.png">Ajouter un membre</span><br><br>';
			foreach($select_all_abonnement_membre as $select_abonnement_membre){
				if(isset($_SESSION['id'])){
					if($select_abonnement_membre['image_profil'] != 'default'){
						echo '	<div class="quiz_utilisateur-div-profil">
									<a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_abonnement_membre['id'].'">
									    <img class="quiz_utilisateur-img-profil"  src="'.$select_abonnement_membre['image_profil'].'">
									    <span>'.$select_abonnement_membre['login'].'</span>
									</a>
								<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$select_abonnement_membre['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
								</div>';
					}else{
						echo '	<div class="quiz_utilisateur-div-profil">
	                                <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_abonnement_membre['id'].'">
                                        <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
                                        <span>'.$select_abonnement_membre['login'].'</span>
									</a>
								<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$select_abonnement_membre['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
								</div>';
					}
				}
			}
			if(count($select_all_abonnement_membre) == 0){
				echo'Vous n\'êtes abonné à aucun membre';
			}
		}
		echo	'
		</div>';
	echo '<div id="ajtMembre2" class="tabcontent">';
		if(isset($_REQUEST['b'])){
			$selectMembresRechercher = $db->query("SELECT * FROM quiz_membre WHERE id != ".$_SESSION['id']." AND login LIKE '%".$_REQUEST['b']."%'")->fetchAll();
			echo '<button><a href="quiz_utilisateur.php?defaultOnglet2=">Retour</a></button>
                  <br><br>';
			if(count($selectMembresRechercher) > 0){
				foreach($selectMembresRechercher as $selectMembreRechercher){
					if(isset($_SESSION['id'])){
						$selectDejaAbonner = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$selectMembreRechercher['id'])->fetchArray();
						if(count($selectDejaAbonner) > 0){
							if($selectMembreRechercher['image_profil'] != 'default'){
								echo '	<div class="quiz_utilisateur-div-ajt-profil">
											<img class="quiz_utilisateur-img-profil"  src="'.$selectMembreRechercher['image_profil'].'">
											<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$selectMembreRechercher['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
										</div>';
							}else{
								echo '	<div class="quiz_utilisateur-div-ajt-profil">
											<img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
											<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$selectMembreRechercher['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
										</div>';
							}
						}else{
							if($selectMembreRechercher['image_profil'] != 'default'){
								echo '	<div class="quiz_utilisateur-div-ajt-profil">
											<img class="quiz_utilisateur-img-profil"  src="'.$selectMembreRechercher['image_profil'].'">
											<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$selectMembreRechercher['id'].'">S\'abonner</a>
										</div>';
							}else{
								echo '	<div class="quiz_utilisateur-div-ajt-profil">
											<img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
											<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
										<a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$selectMembreRechercher['id'].'">S\'abonner</a>
										</div>';
							}
						}
					}else{
						if($selectMembreRechercher['image_profil'] != 'default'){
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
										<img class="quiz_utilisateur-img-profil"  src="'.$selectMembreRechercher['image_profil'].'">
										<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
									<a class="quiz_utilisateur-a-profil" href="identifier.php">S\'abonner</a>
									</div>';
						}else{
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
										<img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
										<span class="quiz_utilisateur-span-ajt-profil">'.$selectMembreRechercher['login'].'</span>
									<a class="quiz_utilisateur-a-profil" href="identifier.php">S\'abonner</a>
									</div>';
						}
					}
				}
			}else{
				echo 'Aucun membre n\'a été trouvé';
			}
		}else{
		    echo "<div class='slider-profil'>";
			$select_all_membre = $db->query("SELECT * FROM quiz_membre WHERE id != ".$_SESSION['id'])->fetchAll();
			foreach($select_all_membre as $select_membre){
				if(isset($_SESSION['id'])){
					$selectDejaAbonner = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id']." AND idUserAbonnement = ".$select_membre['id'])->fetchArray();
					if(count($selectDejaAbonner) > 0){
						if($select_membre['image_profil'] != 'default'){
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
                                        <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
                                            <img class="quiz_utilisateur-img-profil"  src="'.$select_membre['image_profil'].'">
                                            <span>'.$select_membre['login'].'</span>
                                        </a>
									    <a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$select_membre['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
									</div>';
						}else{
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
                                        <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
                                            <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
                                            <span>'.$select_membre['login'].'</span>
                                        </a>
									    <a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$select_membre['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>
									</div>';
						}
					}else{
						if($select_membre['image_profil'] != 'default'){
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
                                        <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
                                            <img class="quiz_utilisateur-img-profil"  src="'.$select_membre['image_profil'].'">
                                            <span>'.$select_membre['login'].'</span>
                                        </a>
                                        <a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$select_membre['id'].'">S\'abonner</a>
									</div>';
						}else{
							echo '	<div class="quiz_utilisateur-div-ajt-profil">
                                        <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
                                            <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
                                            <span>'.$select_membre['login'].'</span>
                                        </a>
                                        <a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$select_membre['id'].'">S\'abonner</a>
									</div>';
						}
					}
				}else{
					if($select_membre['image_profil'] != 'default'){
						echo '	<div class="quiz_utilisateur-div-ajt-profil">
									<a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
									    <img class="quiz_utilisateur-img-profil"  src="'.$select_membre['image_profil'].'">
									    <span>'.$select_membre['login'].'</span>
									</a>
								    <a class="quiz_utilisateur-a-profil" href="identifier.php">S\'abonner</a>
								</div>';
					}else{
						echo '	<div class="quiz_utilisateur-div-ajt-profil">
									<a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_membre['id'].'">
									    <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
									    <span>'.$select_membre['login'].'</span>
									</a>
								    <a class="quiz_utilisateur-a-profil" href="identifier.php">S\'abonner</a>
								</div>';
					}
				}
			}
            echo '</div>';
?>
                    <form class="search-form" action="quiz_utilisateur.php" method="get">
                        <div class="search-div-rchrch">
                            <input type="hidden" name="defaultOnglet2" value="">
                            <label class="search-label" for="a"></label>
                            <input class="search-input" type="text" name="b" placeholder="Rechercher un membre à ajouter" autocomplete="off" value="">
                            <svg class="search-svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                            </svg>
                        </div>
                    </form>
<?php
			$select_all_membres = $db->query("SELECT id FROM quiz_membre WHERE id != ".$_SESSION['id'])->fetchAll();
            foreach ($select_all_membres as $key=>$val) { $test1[] = $val["id"];  }

			$select_all_abonnement = $db->query("SELECT idUserAbonnement FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id'])->fetchAll();
            $select_all_abonnement_nbr = $db->query("SELECT idUserAbonnement FROM quiz_subscription_membre WHERE idUser = ".$_SESSION['id'])->numRows();
            foreach ($select_all_abonnement as $key=>$val) { $test2[] = $val["idUserAbonnement"];  }

            if ($select_all_abonnement_nbr == 0){
                $result = $test1;
            } else{
                $result = array_diff($test1, $test2);
            }
            foreach($result as $select_all_abonnement_membre){
                $select_abonnement_membre = $db->query("SELECT * FROM quiz_membre WHERE id = $select_all_abonnement_membre")->fetchArray();
                if(isset($_SESSION['id'])){
                    if($select_abonnement_membre['image_profil'] != 'default'){
                        echo '	<div class="quiz_utilisateur-div-profil">
									<a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_abonnement_membre['id'].'">
									    <img class="quiz_utilisateur-img-profil"  src="'.$select_abonnement_membre['image_profil'].'">
									    <span>'.$select_abonnement_membre['login'].'</span>
									</a>
								<a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$select_abonnement_membre['id'].'">S\'abonner</a>
								</div>';
                    }else{
                        echo '	<div class="quiz_utilisateur-div-profil">
	                                <a class="quiz_utilisateur-class-a-profil"  href="profil.php?u='.$select_abonnement_membre['id'].'">
                                        <img class="quiz_utilisateur-img-profil" src="commun/bouton-profil.png">
                                        <span>'.$select_abonnement_membre['login'].'</span>
									</a>
								<a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$select_abonnement_membre['id'].'">S\'abonner</a>
								</div>';
                    }
                }
            }
		}
    }
?>
            </div>
            <script>
				function openCity(evt, cityName) {
					var i, tabcontent, tablinks;
					tabcontent = document.getElementsByClassName("tabcontent");
					for (i = 0; i < tabcontent.length; i++) {
						tabcontent[i].style.display = "none";
					}
					tablinks = document.getElementsByClassName("tablinks");
					for (i = 0; i < tablinks.length; i++) {
						tablinks[i].className = tablinks[i].className.replace(" active", "");
					}
					document.getElementById(cityName).style.display = "block";
					evt.currentTarget.className += " active";
				}
				// Get the element with id="defaultOpen" and click on it
				
<?php
	if(isset($_REQUEST['defaultOnglet'])){
		echo	'document.getElementById("defaultOnglet").click();';
	}elseif(isset($_REQUEST['defaultOnglet2'])){
		echo	'document.getElementById("ajtMembre").click();';
	}elseif(isset($_REQUEST['defaultOnglet3'])){
		echo	'document.getElementById("mes_quiz_opcity").click();';
	}else{
		echo	'document.getElementById("defaultOpen").click();';
	}
?>
			</script>
            <input id="clipbord_temp" type="text">
		</div>
        <div id="poster_quiz-menu-droit"></div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="commun/slick/slick.min.js"></script>

        <script type="text/javascript">
            $('.slider-profil').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                speed: 600,
                touchMove: true,
                infinite: false

            });
            function copy(txt){
                var text = document.querySelector("#clipbord_temp");
                new_value = "<?php echo $domaine; ?>"+"quiz/makeQuiz.php?id_quiz="+txt;
                text.value = new_value;
                text.select()
                document.execCommand('copy');
                alert("Lien copié : "+new_value+"\nIdentifiant du quiz : "+txt);
            }
        </script>

    </body>
</html>