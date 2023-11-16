<?php
	session_start();
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		include ("../commun/bandeau-admin.php");
		include ('../config.inc.php');
// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT src, alt FROM image";
		$result = $conn->query($sql);
		
		$sql = "SELECT nom_quiz FROM quiz";
		$result1 = $conn->query($sql);
		
		$sql = "SELECT libelle FROM difficulte";
		$result2 = $conn->query($sql);
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Créer un question", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer une question</h1>
							<h2 style="font-size:20px;color:red;">Ajouter une image avant de créer un question!</h2>
							<h2 style="font-size:20px;color:red;">Créer un quiz avant de créer un question!</h2>
							<form action="action-form/creer-question-3.php" method="post" id="form" name="form1">
								<div style="margin-left: -216px;">
									<label for="quiz-select">Choisir un quiz*: </label>
									<select name="quiz" class="quiz-select">';
		if($result1->num_rows > 0) {
			while ($row1 = $result1->fetch_assoc()) {
				echo '					<option value="'.$row1['nom_quiz'].'">'.$row1['nom_quiz'].'</option>';
			}
		}
		echo '						</select>
								</div>';
		$boucle = 1;
		while ($boucle <= $_REQUEST['nombre_question']) {
			echo						'<br>
										<h2>Question '.$boucle.'</h2>
										<div style="margin-left: -35px;">
											<label for="image-select'.$boucle.'">Choisir une image*: </label>
											<select name="image'.$boucle.'" class="image-select">';
				if($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo '					<option value="'.$row['src'].$boucle.'">'.$row['src'].'</option>';
					}
				}
				echo '						</select>
										</div>
										<div style="margin-left: -244px;">
											<label for="texte_bienvenue'.$boucle.'">Texte de bienvenue*: </label>
											<h6 style="display: contents;">(exemple : Deuxième question du quiz de CSS)</h6>
											<input type="text" id="texte_bienvenue'.$boucle.'" name="texte_bienvenue'.$boucle.'" required>
										</div>
										<div style="margin-left: -239px;">
											<label for="difficulte-select'.$boucle.'">Choisir une difficulté*: </label>
											<select name="difficulte'.$boucle.'" class="difficulte-select">';
				if($result2->num_rows > 0) {
					while ($row2 = $result2->fetch_assoc()) {
						echo '					<option value="'.$row2['libelle'].$boucle.'">'.$row2['libelle'].'</option>';
					}
				}
				echo '						</select>
										</div>
										<div style="margin-left: -30px;">
											<label for="question_quiz'.$boucle.'">Question du quiz*: </label>
											<input type="text" id="question_quiz'.$boucle.'" name="question_quiz'.$boucle.'" required>
										</div>
										<div style="display: block;margin-left: -117px;">
											<label for="numero_question'.$boucle.'">Choisir le numéro de la question*: </label>
											<select name="numero_question'.$boucle.'">
												<option value="1'.$boucle.'">1</option>
												<option value="2'.$boucle.'">2</option>
												<option value="3'.$boucle.'">3</option>
												<option value="4'.$boucle.'">4</option>
												<option value="5'.$boucle.'">5</option>
												<option value="6'.$boucle.'">6</option>
												<option value="7'.$boucle.'">7</option>
												<option value="8'.$boucle.'">8</option>
												<option value="9'.$boucle.'">9</option>
												<option value="10'.$boucle.'">10</option>
											</select>
										</div>
										<br>';
			$boucle = $boucle + 1;
		}
		echo						   '<div class="button">
									<input type="submit" value="Envoyer" id="id-bt">
								</div>
							</form>
						</div>
					</body>
				</html>';
	} elseif (isset($_SESSION['login']) && $_SESSION['admin'] == 0){
		echo 'Accés Interdi';
	} else {
		if (!isset($_SESSION['login'])){
			echo 'Conectez vous pour avoir accés a cette page';
		}
	}
?>