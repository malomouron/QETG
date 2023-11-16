<?php
//phpinfo();
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$select_le_quiz = $db->query("SELECT quiz.id_quiz, quiz.id_image_quiz, quiz.nom_quiz, quiz.bienvenue, quiz_image.id_image, quiz_image.src, quiz_image.alt FROM quiz, quiz_image where quiz.id_image_quiz = quiz_image.id_image AND quiz.id_quiz = ".$_REQUEST['id_quiz'])->fetchArray();
?>
<!DOCTYPE html>
<html id="quiz-presentation-html">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.7">
<?php
	$css = array("css.css", "commun/bandeau.css");
	afficher_head($select_le_quiz['nom_quiz'], $css, "UTF-8");
?>
	</head>
		<body id="quiz-presentation-body">
			<div id="quiz-presentation-menu-gauche">
			</div>
			<?php include ('bandeau.php'); ?>
			<div id="quiz-presentation-div11">
				<div id="quiz-presentation-div2">
					<h1 id="quiz-presentation-h1"><?php echo $select_le_quiz['bienvenue']; ?></h1>
				</div>
				<div id="quiz-presentation-div1">
					<p>Bienvenue, merci de visiter mon site, j'espère que vous aurez appris des choses et que ça vous plaira.</p>
					<img id="quiz-presentation-img-quiz-pre" src="<?php echo $select_le_quiz['src']; ?>" alt="<?php echo $select_le_quiz['alt']; ?>">
					<br><br>
					<div class="quiz-presentation-class1">
                        <?php
                            if (isset($_SESSION['id'])){
                                $select_test_prog_nbr = $db->query("SELECT * FROM progression, question, quiz WHERE quiz.id_quiz = quiz_question.id_quiz AND quiz_progression.id_question = quiz_question.id_question AND quiz_progression.id_user = ".$_SESSION['id']." AND quiz_question.id_quiz = ".$select_le_quiz["id_quiz"])->numRows();
                                $select_test_prog = $db->query("SELECT * FROM progression, question, quiz WHERE quiz.id_quiz = quiz_question.id_quiz AND quiz_progression.id_question = quiz_question.id_question AND quiz_progression.id_user = ".$_SESSION['id']." AND quiz_question.id_quiz = ".$select_le_quiz["id_quiz"])->fetchArray();
                                if(($select_test_prog_nbr) ==1 and $select_test_prog['numero_question'] != $select_test_prog['nbrQuestion'] ){
                                    echo '<a href="question.php?id_quiz='.$select_le_quiz["id_quiz"].'&numero_question='.$select_test_prog['numero_question'].'" id="quiz-presentation-a1">Cliquer ici pour commencer le quiz</a>';
                                }else{
                                    echo '<a href="question.php?id_quiz='.$select_le_quiz["id_quiz"].'&numero_question=1" id="quiz-presentation-a1">Cliquer ici pour commencer le quiz</a>';
                                }
                            }else{
                                echo '<a href="question.php?id_quiz='.$select_le_quiz["id_quiz"].'&numero_question=1" id="quiz-presentation-a1">Cliquer ici pour commencer le quiz</a>';
                            }
						?>
					</div>
					<br><br>
				</div>
				<div id="quiz-presentation-div3">
					<h4>Crée par Malo MOURON ©</h4>
					<pre><strong>Politique de confidentialité  À propos de <?php echo $select_le_quiz['nom_quiz'];
	include ('footer.php'); 
?>
 Avertissements  Contacts  Déclaration sur les témoins (cookies)</strong><br><br>(Si vous répondez faux à une question vous recommencer depuis le début)</pre>
				</div>
			</div>
			<div id="quiz-presentation-menu-droit">
			</div>
		<script type="text/javascript">
			// alert(screen.width);
			// alert(screen.height);
		</script>
	</body>
</html>