<?php
    session_start();
	include ('functions.php');
	$nbr_caractere_reponse = 0;
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$selete_question_du_quiz = $db->query("SELECT quiz_question.id_question, quiz_question.id_quiz, quiz_question.id_image_question, quiz_question.texte_bienvenue, 
			quiz_question.id_difficulte, quiz_question.question_texte, quiz_question.numero_question, quiz_image.id_image, 
			quiz_image.src, quiz_image.alt, quiz_difficulte.id_difficulte, quiz_difficulte.libelle
			FROM quiz_question, quiz_image, quiz_difficulte 
			where quiz_question.id_image_question = quiz_image.id_image 
			AND quiz_question.numero_question = ".$_REQUEST['numero_question']." 
			AND quiz_question.id_quiz = ".$_REQUEST['id_quiz']." 
			AND quiz_question.id_difficulte = quiz_difficulte.id_difficulte")->fetchArray();
	$select_les_reponse_des_question = $db->query("SELECT quiz_reponse.id_reponse, quiz_reponse.id_question, quiz_reponse.choix_possible_quiz, quiz_reponse.reponseOK, quiz_reponse.texte_reponse_explicatif	FROM quiz_reponse where quiz_reponse.id_question =".$selete_question_du_quiz['id_question'])->fetchAll();
	$select_nombre_de_question = $db->query("SELECT count(*) nombre_de_question FROM quiz_question where id_quiz = ".$_REQUEST['id_quiz'])->fetchArray();
	if($_GET['numero_question'] == 1){
	    $select_nombre_de_vue = $db->query("SELECT * FROM quiz WHERE id_quiz  = ".$_GET['id_quiz'])->fetchArray();
	    $update_vue = $db->query("UPDATE quiz SET vue = ".($select_nombre_de_vue['vue']+1   )." WHERE id_quiz = ".$_GET['id_quiz']);
    }
    if (isset($_SESSION['id'])){
        $select_prog_nbr =$db->query("SELECT * FROM quiz_progression prog WHERE id_user = ".$_SESSION['id']." and id_question in (select id_question from quiz_question, quiz where quiz.id_quiz = quiz_question.id_quiz and quiz.id_quiz = ".$selete_question_du_quiz['id_quiz'].")")->numRows();
        $select_prog =$db->query("SELECT * quiz_FROM progression prog WHERE id_user = ".$_SESSION['id']." and id_question in (select id_question from quiz_question, quiz where quiz.id_quiz = quiz_question.id_quiz and quiz.id_quiz = ".$selete_question_du_quiz['id_quiz'].")")->fetchArray();
        if ($select_prog_nbr == 0){
            $insert_prog =$db->query("INSERT INTO `quiz_progression` (`id_user`, `id_question`) VALUES (".$_SESSION['id'].", ".$selete_question_du_quiz['id_question'].")");
        }else{
            $update_prog = $db->query("UPDATE quiz_progression set id_question = ".$selete_question_du_quiz['id_question']." WHERE id_user = ".$_SESSION['id']." AND id_question = ".$select_prog['id_question']);
        }
    }
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.6">
<?php
	$css = array("css.css");
	afficher_head('Question '.$selete_question_du_quiz["numero_question"], $css, "UTF-8");
?>
	</head>
	<body>
		<div id="question-div2">
			<h1 id="question-h1-div2"><?php echo $selete_question_du_quiz["texte_bienvenue"] ?></h1>
			<p id="question-p-div2">(Cette question est <?php echo $selete_question_du_quiz["libelle"] ?>)</p>
			<p id="question-p-num-question"><strong>Vous êtes à la question numéro <?php echo $selete_question_du_quiz["numero_question"] ?> / <?php echo $select_nombre_de_question['nombre_de_question']; ?></strong></p>
		</div>
		<div id="question-div1">
			<img id="question-img-quest" id="question-img" src="<?php echo $selete_question_du_quiz["src"] ?>" alt="<?php echo $selete_question_du_quiz["alt"] ?>">
			<h3>Question : <?php echo $selete_question_du_quiz["question_texte"] ?></h3>
		</div>
		<br><br>
		<div id="question-p-question">
<?php
	if (count($select_les_reponse_des_question) > 0) {
// output data of each row
		$numReponse = 1;
		foreach($select_les_reponse_des_question as $row1) {
			if ($numReponse == 1){
				echo '<span class="question-span-repon-poss">';
			} else {
				
				echo '<span class="question-span-repon-poss">';
			}
			echo '<a href="reponse.php?id_question='.$selete_question_du_quiz['id_question'].'&id_reponse='.$row1["id_reponse"].'&numero_question='.$_REQUEST['numero_question'].'&id_quiz='.$_REQUEST['id_quiz'].'&nombre_de_question='.$select_nombre_de_question['nombre_de_question'].'" class="question-class1">Réponse '.$numReponse.': '.$row1["choix_possible_quiz"].'</a>
					</span>';
			$numReponse = $numReponse + 1;
			$nbr_caractere_reponse = $nbr_caractere_reponse + strlen($row1["choix_possible_quiz"]);
		}
	}
	include ('footer.php');
?>
		</div>
	</body>
</html>