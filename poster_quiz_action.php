<?php
	session_start();
    include ('functions.php');
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    if (isset($_SESSION['login'])){

        if ($os == "windos") {
            $repertoireDestination = dirname(__FILE__)."\\quiz_perso\\";
        } else {
            $repertoireDestination = dirname(__FILE__)."/quiz_perso/";
        }
        $nomDestination = "fichier_de_quiz_du_".date("Y-m-d-H-i-s")."_par_".$_SESSION['id'];



        if (isset($_GET['q'])){
            $select_verif_prop = $db->query("SELECT * FROM quiz WHERE id_quiz = ".$_GET['q'])->fetchArray();
            if ($select_verif_prop['id_user'] == $_SESSION['id']) {

                //update quiz + img
                if ($_FILES["image_uploads"]["name"] == ""){
                    $update_quiz_user = $db->query("UPDATE quiz SET nom_quiz = '" . securisation($_POST['name_quiz']) . "', bienvenue = '',portee = ".$_POST['porte']." WHERE id_quiz = ".$_GET['q']);
                }else{
                    if (move_uploaded_file($_FILES["image_uploads"]["tmp_name"], $repertoireDestination . $nomDestination)) {
                        $update_quiz_user = $db->query("UPDATE quiz SET nom_quiz = '" . securisation($_POST['name_quiz']) . "', bienvenue = '".securisation($_POST['descrip_quiz'])."', src = '/quiz_perso/" . $nomDestination . "',portee = ".$_POST['porte']." WHERE id_quiz = ".$_GET['q']);
                    } else {
                        echo "Le fichier n'a pas été uploadé (trop gros ?) ou Le déplacement du fichier temporaire a échoué vérifiez l'existence du répertoire ".$repertoireDestination;
                    }
                }

                //update question
                for ($i = 1 ; $i <= $_POST['nb_question']; $i++){
                    $update_les_question_quiz = $db->query("UPDATE quiz_question SET id_difficulte = '".$_POST["difficult_question$i"]."', question_texte = '".securisation($_POST["question$i"])."' WHERE numero_question = ".$i." AND id_quiz = ".$_GET['q']);
                }

                //update reponse
                $select_all_quest = $db->query("SELECT * FROM quiz_question WHERE id_quiz = ".$_GET['q'])->fetchAll();
                for ($i = 1 ; $i <= $_POST['nb_question']; $i++){
                    $numBonneRep = "bonne_reponse_question_".$i;
                    for($a = 1 ; $a <= $_POST['nbr_response_question_'.$i]; $a++){
                        $post_reponse_text = "rep".$a."q".$i;
                        if ($_POST[$numBonneRep] == $a){
                            $update_les_reponse_de_question = $db->query("UPDATE quiz_reponse SET choix_possible_quiz = '".securisation($_POST[$post_reponse_text])."', reponseOK = 1, texte_reponse_explicatif = '".securisation($_POST["text_explicatif_reponse_$i"])."' WHERE id_question = ".$select_all_quest[($i-1)]['id_question']." AND num_reponse = ".$a);
                        }else{
                            $update_les_reponse_de_question = $db->query("UPDATE quiz_reponse SET choix_possible_quiz = '".securisation($_POST[$post_reponse_text])."', reponseOK = 0, texte_reponse_explicatif = '' WHERE id_question = ".$select_all_quest[($i-1)]['id_question']." AND num_reponse = ".$a);
                        }
                    }
                }

            }else{
                header('Location: identifier.php');
            }
            header('Location: quiz_utilisateur.php?defaultOnglet3=');
        }else{

            //insert quiz + img
            if (move_uploaded_file($_FILES["image_uploads"]["tmp_name"], $repertoireDestination . $nomDestination)) {
                $insert_quiz_user = $db->query("INSERT INTO quiz (id_quiz, id_image_quiz, nom_quiz, bienvenue, xp, id_user, id_quiz_user, src, nbrQuestion,portee) VALUES (NULL, NULL, '" . securisation($_POST['name_quiz']) . "', '".securisation($_POST['descrip_quiz'])."', '5', '" . $_SESSION['id'] . "', '1', '/quiz_perso/" . $nomDestination . "', " . $_POST['nb_question'] . ", ".$_POST['porte'].")");
            } else {
                echo "Le fichier n'a pas été uploadé (trop gros ?) ou Le déplacement du fichier temporaire a échoué vérifiez l'existence du répertoire ".$repertoireDestination;
            }

            //insert question
            $select_quiz_user = $db->query("SELECT * FROM quiz WHERE id_quiz_user = 1 AND id_user = ".$_SESSION['id']." AND nom_quiz = '".$_POST['name_quiz']."'")->fetchArray();
            for ($i = 1 ; $i <= $_POST['nb_question']; $i++){
                $nbrReponse =  $_POST["nbr_response_question_$i"];
                settype($nbrReponse, "int");
                $insert_les_question_quiz = $db->query("INSERT INTO quiz_question (id_question, id_quiz, id_difficulte, question_texte, numero_question, nbrReponse) VALUES (NULL, '".$select_quiz_user['id_quiz']."', '".$_POST["difficult_question$i"]."', '".securisation($_POST["question$i"])."', ".$i.", ".$nbrReponse.")");
            }

            //insert reponse
            $select_questions = $db->query("SELECT * FROM quiz_question WHERE id_quiz = ".$select_quiz_user['id_quiz'])->fetchAll();
            $i = 1;
            foreach ($select_questions as $select_question){
                $numBonneRep = "bonne_reponse_question_".$select_question['numero_question'];
                $nbrRep = $select_question['nbrReponse'];
                for($a = 1 ; $a <= $nbrRep; $a++){
                    $post_reponse_text = "rep".$a."q".$select_question['numero_question'];
                    $insert_les_reponse_de_question = $db->query("INSERT INTO quiz_reponse (id_reponse, id_question, choix_possible_quiz, reponseOK, texte_reponse_explicatif, num_reponse) VALUES (NULL, '".$select_question['id_question']."', '".securisation($_POST[$post_reponse_text])."', '0', '".securisation($_POST["text_explicatif_reponse_$i"])."', ".$a.")");
                }
                $updateBonneRep = $db->query("UPDATE `quiz_reponse` SET `reponseOK` = '1' WHERE id_question = ".$select_question['id_question']." AND num_reponse = ".$_POST[$numBonneRep]);
                $i++;
            }
            $updateQuizFini = $db->query("UPDATE quiz SET quizComplet = '1' WHERE quiz.id_quiz = ".$select_quiz_user['id_quiz']);
            header('Location: quiz_utilisateur.php');
        }
    }else{
		header('Location: quiz_utilisateur.php');
	}
	include ('footer.php');
?>