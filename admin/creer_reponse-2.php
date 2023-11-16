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
		
		$sql = "SELECT question_texte, id_question FROM question";
		$result1 = $conn->query($sql);
		
		$sql = "SELECT libelle FROM difficulte";
		$result2 = $conn->query($sql);
		$row2 = $result2->fetch_assoc();
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
						include ('../functions.php');
						$css = array("CSS.css", "../commun/bandeau-admin.css");
						afficher_head("Créer une reponse", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Créer une reponse</h1>
							<h2 style="font-size:20px;color:red;">Ajouter une image avant de créer une reponse!</h2>
							<h2 style="font-size:20px;color:red;">Créer une question avant de créer une reponse!</h2>
							<form action="action-form/creer-reponse-3.php" method="post" id="form" name="form1">
								<div style="margin-left: 75px;">
									<label for="question-select">Choisir une question*: </label>
									<select name="question" class="question-select" id="select">';
		if($result1->num_rows > 0) {
			while ($row1 = $result1->fetch_assoc()) {
				echo '					<option value="'.$row1['id_question'].'">'.$row1['question_texte'].'</option>';
			}
		}
		echo '						</select>
								</div>';
		$boucle = 1;
		while ($boucle <= $_REQUEST['nombre_reponse']) {
			echo						'<br>
										<h2>Reponse '.$boucle.'</h2>
										<div style="margin-left: -94px;">
											<label for="image-select'.$boucle.'">Choisir une image*: </label>
											<select name="image'.$boucle.'" class="image-select">';
				if($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo '					<option value="'.$row['src'].$boucle.'">'.$row['src'].'</option>';
					}
				}
				echo '						</select>
										</div>
										<div style="margin-left: -227px;">
											<label for="choix_possible_quiz'.$boucle.'">Choix possible dans la question*: </label>
											<h6 style="display: contents;">(exemple : background-color)</h6>
											<input type="text" id="choix_possible_quiz'.$boucle.'" name="choix_possible_quiz'.$boucle.'" required>
										</div>
										<div style="margin-left: -337px;">
											<label for="reponseOK-select'.$boucle.'" style="width: 259px;">Choisir si la reponse est vrai ou fausse*: </label>
											<select name="reponseOK'.$boucle.'" class="reponseOK-select">
												<option value="0'.$boucle.'">faux</option>
												<option value="1'.$boucle.'">vrai</option>
											</select>
										</div>
										<div style="margin-left: -89px;">
											<label for="texte_reponse_explicatif'.$boucle.'">Texte de la reponse qui explique*: </label>
											<input type="text" id="texte_reponse_explicatif'.$boucle.'" name="texte_reponse_explicatif'.$boucle.'" required>
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