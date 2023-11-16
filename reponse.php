<?php
//phpinfo();
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$date = dateToFrench("now" ,"l-d-F-Y");
	$select_reponse_de_question_par_user = $db->query("SELECT quiz_reponse.id_reponse, quiz_reponse.id_question, quiz_reponse.id_image_reponse, quiz_reponse.choix_possible_quiz, quiz_reponse.reponseOK,
	quiz_reponse.texte_reponse_explicatif, quiz_image.id_image, quiz_image.src, quiz_image.alt, quiz_question.id_quiz, quiz_question.numero_question
	FROM quiz_reponse, quiz_image, quiz_question 
	where quiz_reponse.id_question = ".$_REQUEST['id_question']." 
	AND quiz_reponse.id_reponse = ".$_REQUEST['id_reponse']." 
	AND quiz_reponse.id_image_reponse = quiz_image.id_image 
	AND quiz_reponse.id_question = quiz_question.id_question")->fetchArray();
	
	$numero_de_question_suivante = $select_reponse_de_question_par_user['numero_question'] + 1;
//connaitre l'id de la question suivante	
	$select_question_suivante = $db->query("SELECT id_question FROM quiz_question where id_quiz = ".$select_reponse_de_question_par_user['id_quiz']." AND numero_question = ".$numero_de_question_suivante)->fetchArray();
//on calcule le numero de la question pour le lien vers la question suivante
	$lien_question_suivante = $_REQUEST['numero_question'] + 1;
	
	
	if ($select_reponse_de_question_par_user['reponseOK'] == 0) {
		echo '
		<!DOCTYPE html>
		<html>
			<head>';
		$css = array("css.css");
		afficher_head("Réponse-faux", $css, "UTF-8");
		echo'	<meta name="viewport" content="width=device-width, initial-scale=0.6">
			</head>
			<body>
				<div id="reponse-faux-div1">
					<div id"reponse-faux-div2">
						<h1 id="reponse-faux-h1">Faux, tu n\'as pas trouvé</h1>
						<p id="reponse-faux-p">'.$select_reponse_de_question_par_user['texte_reponse_explicatif'].'</p>
					</div>
					<img id="reponse-img-tail" src="'.$select_reponse_de_question_par_user['src'].'" alt="'.$select_reponse_de_question_par_user['alt'].'">
					<br><br><br><br>
					<a id="reponse-faux-a" href="Quiz-presentation.php?id_quiz='.$select_reponse_de_question_par_user["id_quiz"].'">C\'est dommage tu recommence du début</a>
				</div>
			</body>
		</html>';
	}
	if ($_REQUEST['nombre_de_question'] == $select_reponse_de_question_par_user['numero_question'] && $select_reponse_de_question_par_user['reponseOK'] == 1) {
		if (isset($_SESSION['id'])) {
		    $select_verif_stat = $db->query("SELECT * FROM quiz_statistique WHERE id_user = ".$_SESSION['id']." AND id_quiz = ".$_REQUEST['id_quiz'])->numRows();
		    if ($select_verif_stat == 0){
                $insertStatQuiz = $db->query("INSERT INTO quiz_statistique (id_user,id_quiz,date,quiz_utilisateur) VALUES('".$_SESSION['id']."', '".$_REQUEST['id_quiz']."', '".$date."', 0)");
            }
            $select_stat = $db->query("SELECT * FROM quiz_statistique, quiz WHERE quiz.id_quiz = quiz_statistique.id_quiz AND quiz.id_quiz_user = 0 AND quiz_statistique.id_user = ".$_SESSION['id'])->numRows();
            $select_nb_quiz = $db->query("SELECT * FROM quiz WHERE id_quiz_user = 0 ")->numRows();
            $select_nb_quiz_moit = intdiv($select_nb_quiz, 2);
		    if ($select_stat == 1){
                succes($_SESSION['id'],3,$db);
            }elseif ($select_stat == $select_nb_quiz_moit) {
                succes($_SESSION['id'], 2, $db);
            }elseif ($select_stat == $select_nb_quiz) {
                succes($_SESSION['id'], 1, $db);
            }elseif ($select_stat == 5) {
                succes($_SESSION['id'], 6, $db);
            }
		}
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css");
		afficher_head("Réponse-vrai-fin", $css, "UTF-8");
		echo'			<meta name="viewport" content="width=device-width, initial-scale=0.6">
					</head>
					<body>
						<div id="reponse-fin-vrai-div1">
							<div id"reponse-fin-vrai-div2">
								<h1 id="reponse-fin-vrai-h1">Bravo, tu as trouvé</h1>
								<p class="reponse-fin-vrai-p">'.$select_reponse_de_question_par_user['texte_reponse_explicatif'].'</p>
							</div>
							<img id="reponse-img-tail" src="'.$select_reponse_de_question_par_user['src'].'" alt="'.$select_reponse_de_question_par_user['alt'].'">
							<br><br><br><br>
							<a id="reponse-fin-vrai-a" href="index.php">Trés bien ce quiz est fini clique ici pour aller à l\'aceuil</a>
							<p class="reponse-fin-vrai-p">N\'esite pas à faire un autre quiz</p>
						</div>
					</body>
				</html>';
	} elseif ($select_reponse_de_question_par_user['reponseOK'] == 1) {
				echo '
					<!DOCTYPE html>
					<html>
						<head>';
		$css = array("css.css");
		afficher_head("Réponse-vrai", $css, "UTF-8");
		echo'				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<meta name="viewport" content="width=device-width, initial-scale=0.6">
						</head>
						<body>
							<div id="reponse-vrai-div1">
								<div id"reponse-vrai-div2">
									<h1 id="reponse-vrai-h1">Bravo, tu as trouvé</h1>
									<p id="reponse-vrai-p">'.$select_reponse_de_question_par_user['texte_reponse_explicatif'].'</p>
								</div>
								<img id="reponse-img-tail" src="'.$select_reponse_de_question_par_user['src'].'" alt="'.$select_reponse_de_question_par_user['alt'].'">
								<br><br><br><br>
								<a id="reponse-vrai-a" href="question.php?id_question='.$select_question_suivante['id_question'].'&numero_question='.$lien_question_suivante.'&id_quiz='.$_REQUEST['id_quiz'].'">Très bien passons à la suite</a>
							</div>
						</body>
					</html>';
	}
	include ('footer.php');
?>