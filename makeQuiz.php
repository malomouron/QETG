<?php
	session_start();
	include ('functions.php');
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Quiz utilisateur", $css, "UTF-8");
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	include ('bandeau.php');
	echo '<div id="div1_make_quiz">';
	if(isset($_POST["reponsepourquestion1"])){
		$date = dateToFrench("now" ,"l-d-F-Y");
		$selcectQuizUtilisateur = $db->query("SELECT * FROM quiz, quiz_membre WHERE id_quiz_user = 1 AND quiz.id_user = quiz_membre.id AND quiz.id_quiz = ".$_REQUEST['id_quiz'])->fetchArray();
		$selectQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_question WHERE id_quiz = ".$selcectQuizUtilisateur['id_quiz'])->fetchAll();
		echo '<h1 id="h1_make_quiz_note" class="not-margin-start-end">Merci d\'avoir jouer ';
		if(isset($_SESSION['login'])){
			echo $_SESSION['login'];
		}
		$compteur = 0;
		$cle2 = 1;
		foreach($selectQuestionQuizUtilisateur as $row2){
			$selectBonneReponseQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_reponse WHERE num_reponse = ".$_POST["reponsepourquestion$cle2"]." AND id_question = '".$row2['id_question']."'")->fetchArray();
			if($selectBonneReponseQuestionQuizUtilisateur['reponseOK'] == 1){
				$compteur++;
			}
            $cle2++;
		}
		$score = $compteur.'/'.count($selectQuestionQuizUtilisateur);
		echo ' <br><span class="bleu">Votre note est de '.$score.'</span></h1>';
        echo '<div id="div_make_quiz_1">';
        echo '<table id="makequiz_info">
                    <tr>
                        <td>
                            <img id="img_makeuiz_prof" src="quiz'.$selcectQuizUtilisateur['src'].'">
                        </td>
                        <td id="td_make_quiz_2">
                            <span id="span_make_quiz_profil_nom_quiz">'.$selcectQuizUtilisateur['nom_quiz'].'</span><br>
                            <span id="span_make_quiz_profil_login">Fait par : <a class="moon_lien_quie_class" href="profil.php?u='.$selcectQuizUtilisateur['id'].'">'.$selcectQuizUtilisateur['login'].'</a></span>
                            <span id="span_make_quiz_profil_portee">Statut : ';
        if($selcectQuizUtilisateur['portee'] == 1){
            $pubPriv = "Public";
        }
        else{
            $pubPriv = "Privée";
        }
        echo            $pubPriv.'</span><br>
                            <span id="span_make_quiz_profil_nbrQuestion">Nombre de question : '.$selcectQuizUtilisateur['nbrQuestion'].'</span>';
        if ($selcectQuizUtilisateur['bienvenue'] != ""){
            echo '<br><br><p id="span_make_quiz_profil_bienvenue">Description : '.$selcectQuizUtilisateur['bienvenue'].'</p>';
        }

        echo        '</td>
                    </tr>
                </table>';
        echo '<span id="span_make_quiz_profil_vue">Vue : '.$selcectQuizUtilisateur['vue'].'</span><br>
                    <span id="span_make_quiz_profil_xp">XP : +'.$selcectQuizUtilisateur['xp'].'</span><br>';
        echo '</div>';
        echo '<div id="div_make_quiz_2">';
		$cle = 1;
		foreach($selectQuestionQuizUtilisateur as $row){
			$selectallReponseQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_reponse WHERE id_question = '".$row['id_question']."'")->fetchAll();
			$selectReponseQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_reponse WHERE num_reponse = ".$_POST["reponsepourquestion$cle"]." AND id_question = '".$row['id_question']."'")->fetchArray();
            echo '<div class="My_question_make_quiz">';
			echo "<h3 class=\"not-margin-start-end\">Question $cle : ".$row['question_texte'].'</h3>';
			$selectBonneReponse = $db->query("SELECT * FROM quiz_reponse WHERE reponseOK = 1 AND id_question = '".$row['id_question']."'")->fetchArray();
			if($selectReponseQuestionQuizUtilisateur['reponseOK'] == 1){
				echo "<span style=\"color:green;\">Bonne réponse : ";
				if($selectBonneReponse['texte_reponse_explicatif']  ==! ""){
                    echo "<br>";
                    echo "<span id='neutre'>( explication : ". $selectBonneReponse['texte_reponse_explicatif'].")</span>";
				}
				echo "<br>réponse : ".$selectReponseQuestionQuizUtilisateur['choix_possible_quiz'].' </span>';
			}else{
				echo "<span style='color:red;'>Mauvaise réponse : ";
				if($selectBonneReponse['texte_reponse_explicatif'] ==! ""){
				    echo "<br>";
					echo "<span id='neutre'>( explication : ". $selectBonneReponse['texte_reponse_explicatif'].")</span>";
				}
				echo "<br></span>";
				foreach($selectallReponseQuestionQuizUtilisateur as $reponse){
					echo "<span id=\"span-bonne-reponse".$reponse['reponseOK']."\"> réponse : ".$reponse['choix_possible_quiz'].' </span><br>';
				}
			}
            echo '</div>';
			$cle++;
		}
        echo '<br><a id="make_quiz_input_btn_2" class="bleu" href="quiz_utilisateur.php">Suivant</a>';
        echo '</div>';
        $selectStatDejaAjte = $db->query("SELECT * FROM quiz_statistique where id_user = ".$_SESSION['id']." AND id_quiz = ".$selcectQuizUtilisateur['id_quiz'])->fetchArray();
		if (isset($_SESSION['id']) && count($selectStatDejaAjte) == 0) {
			$insertStatQuizUser = $db->query("INSERT INTO quiz_statistique (id_user,id_quiz,date,note) VALUES('".$_SESSION['id']."', '".$selcectQuizUtilisateur['id_quiz']."', '".$date."', ".$compteur.")");
		}
	}elseif(!isset($_POST["reponsepourquestion1"])){
		$selcectQuizUtilisateur = $db->query("SELECT * FROM quiz, quiz_membre WHERE id = id_user AND id_quiz_user = 1 AND id_quiz = ".$_REQUEST['id_quiz'])->fetchArray();
        if(count($selcectQuizUtilisateur) > 0){
            $updateNbrVue = $db->query("UPDATE `quiz` SET `vue` = ".($selcectQuizUtilisateur['vue']+1)." WHERE `quiz`.`id_quiz` = ".$selcectQuizUtilisateur['id_quiz']);
            $selectQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_question WHERE id_quiz = ".$selcectQuizUtilisateur['id_quiz'])->fetchAll();
			echo '<h1 id="h1_make_quiz_note" class="not-margin-start-end">Bienvenu dans ce quiz ';
			if(isset($_SESSION['login'])){
				echo $_SESSION['login'];
			}
			echo '</h1>';
			echo '<div id="div_make_quiz_1">';
            echo '<table id="makequiz_info">
                    <tr>
                        <td>
                            <img id="img_makeuiz_prof" src="/quiz'.$selcectQuizUtilisateur['src'].'">
                        </td>
                        <td id="td_make_quiz_2">
                            <span id="span_make_quiz_profil_nom_quiz">'.$selcectQuizUtilisateur['nom_quiz'].'</span><br>
                            <span id="span_make_quiz_profil_login">Fait par : <a class="moon_lien_quie_class" href="profil.php?u='.$selcectQuizUtilisateur['id'].'">'.$selcectQuizUtilisateur['login'].'</a></span>
                            <span id="span_make_quiz_profil_portee">Statut : ';
            if($selcectQuizUtilisateur['portee'] == 1){
                $pubPriv = "Public";
            }
            else{
                $pubPriv = "Privée";
            }
            echo            $pubPriv.'</span><br>
                            <span id="span_make_quiz_profil_nbrQuestion">Nombre de question : '.$selcectQuizUtilisateur['nbrQuestion'].'</span>';
            if ($selcectQuizUtilisateur['bienvenue'] != ""){
                echo '<br><br><p id="span_make_quiz_profil_bienvenue">Description : '.$selcectQuizUtilisateur['bienvenue'].'</p>';
            }

            echo        '</td>
                    </tr>
                </table>';
            echo '<span id="span_make_quiz_profil_vue">Vue : '.$selcectQuizUtilisateur['vue'].'</span><br>
                    <span id="span_make_quiz_profil_xp">XP : +'.$selcectQuizUtilisateur['xp'].'</span><br>';
            echo '</div>';
            echo '<div id="div_make_quiz_2">';
            echo '<form method="post" action="makeQuiz.php">';
			$cle = 1;
			echo '<input type="hidden" name="id_quiz" value="'.$_REQUEST['id_quiz'].'">';
			foreach($selectQuestionQuizUtilisateur as $row){
				$selectReponseQuestionQuizUtilisateur = $db->query("SELECT * FROM quiz_reponse WHERE id_question = '".$row['id_question']."'")->fetchAll();
				echo '<div class="My_question_make_quiz">';
                echo "<h3 class=\"    \">Question $cle : ".$row['question_texte'].'</h3>';
                $cle2 = 1;
                foreach($selectReponseQuestionQuizUtilisateur as $row2){
                    echo "<label for='reponsepourquestion".$cle."'> réponse $cle2 : ".$row2['choix_possible_quiz'].' </label><input value="'.$cle2.'" name="reponsepourquestion'.$cle.'" type="radio" required><br>';
                    $cle2++;
                }
                echo '</div>';

                $cle++;
			}
			echo '<input id="make_quiz_input_btn" value="Confirmer" type="submit">
				</form>';
            echo '</div>';
		}else{
			echo 'Problème : Aucun quiz trouvé';
		}
	}
	echo '</div>';
	include ('footer.php');
?>