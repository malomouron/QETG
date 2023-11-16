<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if (isset($_SESSION['login'])){
		echo 	'<!DOCTYPE html>
				<html>
					<head>
        				<style type="text/css">
							.form {
								width: 600px;
								background: #ccc;
								margin: 0 auto;
								padding: 20px;
								border: 1px solid black;
							}
							
							form ol {
								padding-left: 0;
							}
							
							form li, div > p {
								background: #eee;
								display: flex;
								justify-content: space-between;
								margin-bottom: 10px;
								list-style-type: none;
								border: 1px solid black;
							}
							
							form img {
								height: 64px;
								order: 1;
							}
							
							form p {
								line-height: 32px;
								padding-left: 10px;
							}
							
							#label_uplod, form button {
								background-color: #7F9CCB;
								padding: 5px 10px;
								border-radius: 5px;
								border: 1px ridge black;
								font-size: 0.8rem;
								height: auto;
							}
							
							#label_uplod:hover, form button:hover {
								background-color: #2D5BA3;
								color: white;
							}
							
							#label_uplod:active, form button:active {
								background-color: #0D3F8F;
								color: white;
							}
       					</style>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Poster des quiz", $css, "UTF-8");
		if (isset($_GET['q']) ){
		    $select_verif_prop = $db->query("SELECT * FROM quiz WHERE id_quiz = ".$_GET['q'])->fetchArray();
		    if ($select_verif_prop['id_user'] == $_SESSION['id']){
		        $select_questions_modif = $db->query("SELECT * FROM quiz_question WHERE id_quiz = ".$select_verif_prop['id_quiz'])->fetchAll();
		        foreach ($select_questions_modif as $select_question_modif){
                    $select_reponse_modif[]= $db->query("SELECT * FROM quiz_reponse WHERE id_question = ".$select_question_modif['id_question'])->fetchAll();
                }
                echo'</head>
					<body>
					    <div id="poster_quiz-menu-gauche"></div>
						<div id="poster_quiz-div1">
							<h1>Modifier un quiz</h1>
							<form enctype="multipart/form-data" method="post" action="poster_quiz_action.php?q='.$_GET['q'].'">
                                <div class ="form">
                                    <h2 id="h2_modi_quiz">Quiz</h2>
                                    <img id="img_ancien_logo_modif" src="/quiz'.$select_verif_prop['src'].'" alt="Ancien logo">
                                    <div></div>
                                    <div>
                                        <label id="label_uplod" for="image_uploads">Nouvelle Photo de présentation du quiz</label>
                                        <input type="file" id="image_uploads" name="image_uploads" accept=".png,.jpg,.gif,.svg,.bmp,.tiff" multiple="" style="opacity: 0;">
                                    </div>
                                    <div class="preview">
                                        <p id="p_uplod">Aucun fichier sélectionné pour le moment</p>
                                    </div>
                                    <label for="name_quiz">Nom du quiz : </label><input value="'.$select_verif_prop['nom_quiz'].'" type="text" name="name_quiz" required>
                                    <div class="espace_input_poster"></div>
                                    <label for="nb_question">Nombre de question : </label><input name="nb_question" readonly="readonly" min="1" id="nbr_quest" max="100" type="number" value="'.$select_verif_prop['nbrQuestion'].'" required>
                                    <div class="espace_input_poster"></div>';
                if ($select_verif_prop['portee'] == 1){
                    echo'<input type="radio" name="porte" value="1" checked required><label>Public</label><input type="radio" name="porte" value="0" required><label>Privé</label><br>';
                }else{
                    echo'<input type="radio" name="porte" value="1" required><label>Public</label><input type="radio" name="porte" value="0" required checked><label>Privé</label><br>';
                }

                echo'               <label id="label_post_desc_rel">Descrition (Facultatif): </label><textarea name="descrip_quiz">'.$select_verif_prop['bienvenue'].'</textarea>
                                    <br>
                                </div>
                                <div class ="form" id="question_post_form">
                                    <h2>Question : </h2>
                                    <div id="conteneur_quest_post" >
                                    </div>
                                </div>
                                <div class ="form" id="reponse_post_form">
                                    <h2>Réponse</h2>
                                    <div id="conteneur_rep_post" >
                                        <div class="mes_reponse" id="ma_reponse1">
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class ="form" id="question_post_input">
                                    <input type="submit" value="Modifier">
                                    <a id="mon_lien_retour_modif_post" href="quiz_utilisateur.php">Retour</a>
                                </div>
                            </form>
						</div>';
                echo'   <script>
							function nbr_question(){
							    var nbr = '.$select_verif_prop['nbrQuestion'].';
							    
							    var container_div = document.getElementById("conteneur_quest_post");
							    var container_form = document.getElementById("question_post_form");
							    container_div.remove();
							    var newDivQuest = document.createElement("div");
							    newDivQuest.id = "conteneur_quest_post";
							    
							    var container_div_rep = document.getElementById("conteneur_rep_post");
							    var container_form_rep = document.getElementById("reponse_post_form");
							    container_div_rep.remove();
							    var newDivRep = document.createElement("div");
							    newDivRep.id = "conteneur_rep_post";
							    
							    var select_mes_question = ';
                echo json_encode($select_questions_modif);
                echo';
                                var select_mes_reponse = ';
                echo json_encode($select_reponse_modif);
                echo';
							    for ( x=0; x<nbr; x++){
							        
							        var newSelectQuest = document.createElement("select");
							        newSelectQuest.name = "difficult_question"+(x+1);
							        var difficulter = ["Très simple","Simple","Moyenne","Difficile","Très difficile"];
							        for (i=0; i<5;i++){
							            var newOptQuest = document.createElement("option");
							            newOptQuest.value = (i+1);
							            newOptQuest.innerHTML = difficulter[i];
							            if (select_mes_question[x]["id_difficulte"] == (i+1)){
							            
							               newOptQuest.selected = "selected"; 
							            }
							            newSelectQuest.appendChild(newOptQuest);
							        }
							        
							        var newLabelQuestNbrRep = document.createElement("label");
							        newLabelQuestNbrRep.htmlFor = "nbr_response_question_"+(x+1)
							        newLabelQuestNbrRep.innerHTML = "Nombre de réponse à la question "+(x+1)+" : ";
							        
							        var newSelectQuestNbrRep = document.createElement("select");
							        newSelectQuestNbrRep.name = "nbr_response_question_"+(x+1);
							        newSelectQuestNbrRep.id = "nbr_response_question_"+(x+1);
							        newSelectQuestNbrRep.className = "nbr_response_question";
							        newSelectQuestNbrRep.setAttribute(\'aria-disabled\', \'true\');
							        
							        for (i=0; i<4;i++){
							            var newOpttQuestNbrRep = document.createElement("option");
							            newOpttQuestNbrRep.value = (i+2);
							            newOpttQuestNbrRep.innerHTML = (i+2)+" choix";
							            if (select_mes_question[x]["nbrReponse"] == (i+2)){
							               newOpttQuestNbrRep.selected = "selected"; 
							            }
							            newSelectQuestNbrRep.appendChild(newOpttQuestNbrRep);
							        }
							        
							        var newLabelQuest = document.createElement("label");
							        newLabelQuest.htmlFor =  "question"+(x+1);
							        newLabelQuest.innerHTML = "Question "+(x+1)+" : ";
							        
							        var newInputQuest = document.createElement("input");
							        newInputQuest.className =  "my_question_post";
							        newInputQuest.name = "question"+(x+1);
							        newInputQuest.id = "question"+(x+1);
							        newInputQuest.type = "text";
                                    newInputQuest.required = true;
                                    newInputQuest.value = select_mes_question[x]["question_texte"];
                                    
                                    newDivQuest.appendChild(newLabelQuest);
                                    newDivQuest.appendChild(newInputQuest);
                                    newDivQuest.appendChild(newSelectQuest);
                                    newDivQuest.appendChild(document.createElement("br"));
                                    newDivQuest.appendChild(newLabelQuestNbrRep);
                                    newDivQuest.appendChild(newSelectQuestNbrRep);
                                    newDivQuest.appendChild(document.createElement("br"));
                                    newDivQuest.appendChild(document.createElement("br"));
							    }
							    container_form.appendChild(newDivQuest);
							    
							    
							    for ( x=0; x<nbr; x++){
							        var ma_question_div = document.createElement("div");
							        ma_question_div.className="mes_reponse";
							        ma_question_div.id="ma_reponse"+(x+1);
							        var nbrReponseQue = select_mes_question[x]["nbrReponse"];
							        for (i=0 ; i<nbrReponseQue;i++){
							            
                                        var newLabelRepText = document.createElement("label");
                                        newLabelRepText.innerHTML = "Réponse "+(i+1)+" (Q"+(x+1)+") : ";
                                        newLabelRepText.htmlFor = "rep"+(i+1)+"q"+(x+1);
                                        
                                        var newInputRep = document.createElement("input");
                                        newInputRep.id = "rep"+(i+1)+"q"+(x+1);
                                        newInputRep.name = "rep"+(i+1)+"q"+(x+1);
                                        newInputRep.className = "my_rep_post";
                                        newInputRep.type = "text";
                                        newInputRep.required = true;
                                        newInputRep.value = select_mes_reponse[x][i]["choix_possible_quiz"];
                                        
                                        ma_question_div.appendChild(newLabelRepText);
                                        ma_question_div.appendChild(newInputRep);
                                        ma_question_div.appendChild(document.createElement("br"));
							        }
							        
							        var newLabelRepText = document.createElement("label");
                                    newLabelRepText.innerHTML = "Numéro de la bonne réponse : ";
                                    newLabelRepText.htmlFor = "bonne_reponse_question_"+(x+1);
                                    ma_question_div.appendChild(newLabelRepText);
							        
							        for (i=0 ; i<nbrReponseQue;i++){
							            var newLabelRepTextNum= document.createElement("label");
                                        newLabelRepTextNum.innerHTML = i+1;
                                        
                                        var newInputRepBonne = document.createElement("input");
                                        newInputRepBonne.name = "bonne_reponse_question_"+(x+1);
                                        newInputRepBonne.value = i+1;
                                        newInputRepBonne.type = "radio";
                                        newInputRepBonne.required = true;
                                        if (select_mes_reponse[x][i]["reponseOK"] == 1){
                                            newInputRepBonne.checked = true;
                                            var temps = select_mes_reponse[x][i]["texte_reponse_explicatif"];
                                        }
                                        ma_question_div.appendChild(newLabelRepTextNum);
                                        ma_question_div.appendChild(newInputRepBonne);
							        }
							        
                                    ma_question_div.appendChild(document.createElement("br"));
                                    var newLabelRepTextExplicarion = document.createElement("label");
                                    newLabelRepTextExplicarion.htmlFor = "text_explicatif_reponse_"+(x+1) 
                                    newLabelRepTextExplicarion.innerHTML = "Explication de la bonne reponse (Facultatif): "
                                    ma_question_div.appendChild(newLabelRepTextExplicarion);
                                    
                                    var newTexareaExplica = document.createElement("textarea");
                                    newTexareaExplica.name = "text_explicatif_reponse_"+(x+1);
                                    newTexareaExplica.innerHTML = temps;
                                    
                                    ma_question_div.appendChild(newTexareaExplica);
                                    
                                    ma_question_div.appendChild(document.createElement("br"));
                                    ma_question_div.appendChild(document.createElement("br"));
							        newDivRep.appendChild(ma_question_div);
							    }
							    container_form_rep.appendChild(newDivRep);
							}
							'.'
							var input = document.querySelector(\'input\');
							var preview = document.querySelector(\'.preview\');
							
							input.style.opacity = 0;
							input.addEventListener(\'change\', updateImageDisplay);
							function updateImageDisplay() {
								while(preview.firstChild) {
									preview.removeChild(preview.firstChild);
								}
								
								var curFiles = input.files;
								if(curFiles.length === 0) {
									var para = document.createElement(\'p\');
									para.textContent = \'Pas de fichier selectionner pour l\\\'upload\';
									preview.appendChild(para);
								} else {
									var list = document.createElement(\'ol\');
									preview.appendChild(list);
									for(var i = 0; i < curFiles.length; i++) {
									var listItem = document.createElement(\'li\');
									var para = document.createElement(\'p\');
									if(validFileType(curFiles[i])) {
										para.textContent = \'Nom du ficher : \' + curFiles[i].name + \', taille : \' + returnFileSize(curFiles[i].size) + \'.\';
										var image = document.createElement(\'img\');
										image.src = window.URL.createObjectURL(curFiles[i]);
								
										listItem.appendChild(image);
										listItem.appendChild(para);
								
									} else {
										para.textContent = \'Nom du ficher :\' + curFiles[i].name + \': Format de fichier non valide. Changez de fichier.\';
										listItem.appendChild(para);
									}
								
									list.appendChild(listItem);
									}
								}
							}
							var fileTypes = [
								\'image/png\',
								\'image/gif\',
								\'image/svg\',
								\'image/bmp\',
								\'image/tiff\',
								\'image/jpg\'
							]
							
							function validFileType(file) {
								for(var i = 0; i < fileTypes.length; i++) {
									if(file.type === fileTypes[i]) {
									return true;
									}
								}
								return false;
							}
							function returnFileSize(number) {
								if(number < 1024) {
									return number + \' octets\';
								} else if(number >= 1024 && number < 1048576) {
									return (number/1024).toFixed(1) + \' Ko\';
								} else if(number >= 1048576) {
									return (number/1048576).toFixed(1) + \' Mo\';
								}
							}'.'
                            nbr_question();
						</script>
						<div id="poster_quiz-menu-droit"></div>
					</body>
				</html>';
                include ("bandeau.php");
            }else{
		        echo  'Vous n\'êtes pas le propriétaire de ce quiz';
            }
        }else{
            echo	'</head>
					<body>
					    <div id="poster_quiz-menu-gauche"></div>
						<div id="poster_quiz-div1">
							<h1>Poster un quiz</h1>
							<form enctype="multipart/form-data" method="post" action="poster_quiz_action.php">
                                <div class ="form">
                                    <h2>Quiz</h2>
                                    <div>
                                        <label id="label_uplod" for="image_uploads">Photo de présentation du quiz</label>
                                        <input type="file" id="image_uploads" name="image_uploads" accept=".png,.jpg,.gif,.svg,.bmp,.tiff" multiple="" style="opacity: 0;" required>
                                    </div>
                                    <div class="preview">
                                        <p id="p_uplod">Aucun fichier sélectionné pour le moment</p>
                                    </div>
                                    <label for="name_quiz">Nom du quiz : </label><input type="text" name="name_quiz" required>
                                    <div class="espace_input_poster"></div>
                                    <label for="nb_question">Nombre de question</label><input name="nb_question" min="1" value="1" id="nbr_quest" onchange="nbr_question();" max="100" type="number" required>
                                    <div class="espace_input_poster"></div>
                                    <input type="radio" name="porte" value="1" checked required><label>Public</label><input type="radio" name="porte" value="0" required><label>Privé</label><br>
                                    <label id="label_post_desc_rel">Descrition (Facultatif): </label><textarea name="descrip_quiz"></textarea>
                                    <br>
                                </div>
                                <div class ="form" id="question_post_form">
                                    <h2>Question : </h2>
                                    <div id="conteneur_quest_post">
                                        <label for="question1">Question 1 : </label><input id="question1" class="my_question_post" type="text" name="question1" required>
                                        <select name="difficult_question1">
                                            <option value="1">Très simple</option>
                                            <option value="2">Simple</option>
                                            <option value="3">Moyenne</option>
                                            <option value="4">Difficile</option>
                                            <option value="5">Très difficile</option>
                                        </select><br>
                                        <label for="nbr_response_question_1">Nombre de proposition de reponse : </label>
                                        <select onchange="nbr_Rep(1);" name="nbr_response_question_1">
                                            <option value="2">2 choix</option>
                                            <option value="3">3 choix</option>
                                            <option value="4">4 choix</option>
                                            <option value="5">5 choix</option>
                                        </select><br><br>
                                    </div>
                                </div>
                                <div class ="form" id="reponse_post_form">
                                    <h2>Réponse</h2>
                                    <div id="conteneur_rep_post">
                                        <div class="mes_reponse" id="ma_reponse1">
                                            <label for="rep1q1">Réponse 1 (Q1) : </label><input id="rep1q1" class="my_rep_post" type="text" name="rep1q1" required><br>
                                            <label for="rep2q1">Réponse 2 (Q1) : </label><input id="rep2q1" class="my_rep_post" type="text" name="rep2q1" required><br>
                                            <label for="bonne_reponse_question_1">Numéro de la bonne réponse : </label>
                                            <label>1</label><input type="radio" name="bonne_reponse_question_1" value="1" required>
                                            <label>2</label><input type="radio" name="bonne_reponse_question_1" value="2" required><br>
                                            <label for="text_explicatif_reponse_1">Explication de la bonne reponse (Facultatif): </label>
                                            <textarea name="text_explicatif_reponse_1"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class ="form" id="question_post_input">
                                    <input type="submit">
                                </div>
                            </form>
						</div>';
            echo'			<script>
        				    var input = document.querySelector(\'input\');
							var preview = document.querySelector(\'.preview\');
							
							input.style.opacity = 0;
							input.addEventListener(\'change\', updateImageDisplay);
							function updateImageDisplay() {
								while(preview.firstChild) {
									preview.removeChild(preview.firstChild);
								}
								
								var curFiles = input.files;
								if(curFiles.length === 0) {
									var para = document.createElement(\'p\');
									para.textContent = \'Pas de fichier selectionner pour l\\\'upload\';
									preview.appendChild(para);
								} else {
									var list = document.createElement(\'ol\');
									preview.appendChild(list);
									for(var i = 0; i < curFiles.length; i++) {
									var listItem = document.createElement(\'li\');
									var para = document.createElement(\'p\');
									if(validFileType(curFiles[i])) {
										para.textContent = \'Nom du ficher : \' + curFiles[i].name + \', taille : \' + returnFileSize(curFiles[i].size) + \'.\';
										var image = document.createElement(\'img\');
										image.src = window.URL.createObjectURL(curFiles[i]);
								
										listItem.appendChild(image);
										listItem.appendChild(para);
								
									} else {
										para.textContent = \'Nom du ficher :\' + curFiles[i].name + \': Format de fichier non valide. Changez de fichier.\';
										listItem.appendChild(para);
									}
								
									list.appendChild(listItem);
									}
								}
							}
							var fileTypes = [
								\'image/png\',
								\'image/gif\',
								\'image/svg\',
								\'image/bmp\',
								\'image/tiff\',
								\'image/jpg\'
							]
							
							function validFileType(file) {
								for(var i = 0; i < fileTypes.length; i++) {
									if(file.type === fileTypes[i]) {
									return true;
									}
								}
								return false;
							}
							function returnFileSize(number) {
								if(number < 1024) {
									return number + \' octets\';
								} else if(number >= 1024 && number < 1048576) {
									return (number/1024).toFixed(1) + \' Ko\';
								} else if(number >= 1048576) {
									return (number/1048576).toFixed(1) + \' Mo\';
								}
							}
							function nbr_question(){
							    var nbr = document.getElementById("nbr_quest").value;
							    
							    var container_div = document.getElementById("conteneur_quest_post");
							    var container_form = document.getElementById("question_post_form");
							    container_div.remove();
							    var newDivQuest = document.createElement("div");
							    newDivQuest.id = "conteneur_quest_post";
							    
							    var container_div_rep = document.getElementById("conteneur_rep_post");
							    var container_form_rep = document.getElementById("reponse_post_form");
							    container_div_rep.remove();
							    var newDivRep = document.createElement("div");
							    newDivRep.id = "conteneur_rep_post";
							    
							    for ( x=0; x<nbr; x++){
							        
							        var newSelectQuest = document.createElement("select");
							        newSelectQuest.name = "difficult_question"+(x+1);
							        var difficulter = ["Très simple","Simple","Moyenne","Difficile","Très difficile"];
							        for (i=0; i<5;i++){
							            var newOptQuest = document.createElement("option");
							            newOptQuest.value = (i+1);
							            newOptQuest.innerHTML = difficulter[i];
							            newSelectQuest.appendChild(newOptQuest);
							        }
							        
							        var newLabelQuestNbrRep = document.createElement("label");
							        newLabelQuestNbrRep.htmlFor = "nbr_response_question_"+(x+1)
							        newLabelQuestNbrRep.innerHTML = "Nombre de réponse à la question "+(x+1)+" : ";
							        
							        var newSelectQuestNbrRep = document.createElement("select");
							        newSelectQuestNbrRep.name = "nbr_response_question_"+(x+1);
							        newSelectQuestNbrRep.setAttribute("onchange","nbr_Rep("+(x+1)+");");
							        for (i=0; i<4;i++){
							            var newOpttQuestNbrRep = document.createElement("option");
							            newOpttQuestNbrRep.value = (i+2);
							            newOpttQuestNbrRep.innerHTML = (i+2)+" choix";
							            newSelectQuestNbrRep.appendChild(newOpttQuestNbrRep);
							        }
							        
							        var newLabelQuest = document.createElement("label");
							        newLabelQuest.htmlFor =  "question"+(x+1);
							        newLabelQuest.innerHTML = "Question "+(x+1)+" : ";
							        
							        var newInputQuest = document.createElement("input");
							        newInputQuest.className =  "my_question_post";
							        newInputQuest.name = "question"+(x+1);
							        newInputQuest.id = "question"+(x+1);
							        newInputQuest.type = "text";
                                    newInputQuest.required = true;
							        
							        
							        
							        
                                    newDivQuest.appendChild(newLabelQuest);
                                    newDivQuest.appendChild(newInputQuest);
                                    newDivQuest.appendChild(newSelectQuest);
                                    newDivQuest.appendChild(document.createElement("br"));
                                    newDivQuest.appendChild(newLabelQuestNbrRep);
                                    newDivQuest.appendChild(newSelectQuestNbrRep);
                                    newDivQuest.appendChild(document.createElement("br"));
                                    newDivQuest.appendChild(document.createElement("br"));
							    }
							    container_form.appendChild(newDivQuest);
							    
							    
							    for ( x=0; x<nbr; x++){
							        var ma_question_div = document.createElement("div");
							        ma_question_div.className="mes_reponse";
							        ma_question_div.id="ma_reponse"+(x+1);
							        var nbrReponseQue = document.getElementsByName("nbr_response_question_"+(x+1))[0].value;
							        for (i=0 ; i<nbrReponseQue;i++){
							            
                                        var newLabelRepText = document.createElement("label");
                                        newLabelRepText.innerHTML = "Réponse "+(i+1)+" (Q"+(x+1)+") : ";
                                        newLabelRepText.htmlFor = "rep"+(i+1)+"q"+(x+1);
                                        
                                        var newInputRep = document.createElement("input");
                                        newInputRep.id = "rep"+(i+1)+"q"+(x+1);
                                        newInputRep.name = "rep"+(i+1)+"q"+(x+1);
                                        newInputRep.className = "my_rep_post";
                                        newInputRep.type = "text";
                                        newInputRep.required = true;
                                        
                                        ma_question_div.appendChild(newLabelRepText);
                                        ma_question_div.appendChild(newInputRep);
                                        ma_question_div.appendChild(document.createElement("br"));
							        }
							        
							        var newLabelRepText = document.createElement("label");
                                    newLabelRepText.innerHTML = "Numéro de la bonne réponse : ";
                                    newLabelRepText.htmlFor = "bonne_reponse_question_"+(x+1);
                                    ma_question_div.appendChild(newLabelRepText);
							        
							        for (i=0 ; i<nbrReponseQue;i++){
							            var newLabelRepTextNum= document.createElement("label");
                                        newLabelRepTextNum.innerHTML = i+1;
                                        
                                        var newInputRepBonne = document.createElement("input");
                                        newInputRepBonne.name = "bonne_reponse_question_"+(x+1);
                                        newInputRepBonne.value = i+1;
                                        newInputRepBonne.type = "radio";
                                        newInputRepBonne.required = true;
                                        
                                        ma_question_div.appendChild(newLabelRepTextNum);
                                        ma_question_div.appendChild(newInputRepBonne);
							        }
							        
                                    ma_question_div.appendChild(document.createElement("br"));
                                    var newLabelRepTextExplicarion = document.createElement("label");
                                    newLabelRepTextExplicarion.htmlFor = "text_explicatif_reponse_"+(x+1) 
                                    newLabelRepTextExplicarion.innerHTML = "Explication de la bonne reponse (Facultatif): "
                                    ma_question_div.appendChild(newLabelRepTextExplicarion);
                                    
                                    var newTexareaExplica = document.createElement("textarea");
                                    newTexareaExplica.name = "text_explicatif_reponse_"+(x+1)
                                    ma_question_div.appendChild(newTexareaExplica);
                                    
                                    ma_question_div.appendChild(document.createElement("br"));
                                    ma_question_div.appendChild(document.createElement("br"));
							        newDivRep.appendChild(ma_question_div);
							    }
							    container_form_rep.appendChild(newDivRep);
							}'.'
							function nbr_Rep(id){
							    var mes_reponse = document.getElementsByClassName("mes_reponse");
                                var nbrReponse = document.getElementsByName("nbr_response_question_"+id)[0].value;
							    var parentDiv = document.getElementById("conteneur_rep_post");
							    mes_reponse[id-1].remove();
							    
							    var ma_question_div = document.createElement("div");
                                ma_question_div.className="mes_reponse";
                                ma_question_div.id="ma_reponse"+id;
                                for (i=0 ; i<nbrReponse;i++){
                                    
                                    var newLabelRepText = document.createElement("label");
                                    newLabelRepText.innerHTML = "Réponse "+(i+1)+" (Q"+id+") : ";
                                    newLabelRepText.htmlFor = "rep"+(i+1)+"q"+id;
                                    
                                    var newInputRep = document.createElement("input");
                                    newInputRep.id = "rep"+(i+1)+"q"+id;
                                    newInputRep.name = "rep"+(i+1)+"q"+id;
                                    newInputRep.className = "my_rep_post";
                                    newInputRep.type = "text";
                                    newInputRep.required = true;
                                    
                                    ma_question_div.appendChild(newLabelRepText);
                                    ma_question_div.appendChild(newInputRep);
                                    ma_question_div.appendChild(document.createElement("br"));
                                }
                                
                                var newLabelRepText = document.createElement("label");
                                newLabelRepText.innerHTML = "Numéro de la bonne réponse : ";
                                newLabelRepText.htmlFor = "bonne_reponse_question_"+id;
                                ma_question_div.appendChild(newLabelRepText);
                                
                                for (i=0 ; i<nbrReponse;i++){
                                    var newLabelRepTextNum= document.createElement("label");
                                    newLabelRepTextNum.innerHTML = i+1;
                                    
                                    var newInputRepBonne = document.createElement("input");
                                    newInputRepBonne.name = "bonne_reponse_question_"+(id);
                                    newInputRepBonne.value = i+1;
                                    newInputRepBonne.type = "radio";
                                    newInputRepBonne.required = true;
                                    
                                    ma_question_div.appendChild(newLabelRepTextNum);
                                    ma_question_div.appendChild(newInputRepBonne);
                                }
                                
                                ma_question_div.appendChild(document.createElement("br"));
                                var newLabelRepTextExplicarion = document.createElement("label");
                                newLabelRepTextExplicarion.htmlFor = "text_explicatif_reponse_"+id
                                newLabelRepTextExplicarion.innerHTML = "Explication de la bonne reponse (Facultatif): "
                                ma_question_div.appendChild(newLabelRepTextExplicarion);
                                
                                var newTexareaExplica = document.createElement("textarea");
                                newTexareaExplica.name = "text_explicatif_reponse_"+id
                                ma_question_div.appendChild(newTexareaExplica);
                                
                                ma_question_div.appendChild(document.createElement("br"));
                                ma_question_div.appendChild(document.createElement("br"));
							    parentDiv.insertBefore(ma_question_div, parentDiv.children[id-1])
							}
						</script>
						<div id="poster_quiz-menu-droit"></div>
					</body>
				</html>';
            include ("bandeau.php");
        }
	}else{
		header('Location: identifier.php');
	}
	include ('footer.php');
?>