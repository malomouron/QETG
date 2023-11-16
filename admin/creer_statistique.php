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
		$sql = "SELECT login, id FROM membre";
		$result = $conn->query($sql);
		
		$sql = "SELECT nom_quiz FROM quiz";
		$result1 = $conn->query($sql);
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Ajouter un statistique", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Ajouter un statistique</h1>
							<form action="action-form/creer-statistique-2.php" method="post" id="form" name="form1">
								<div style="margin-left: -35px;">
									<label for="utilisateur-select">Choisir un utilisateur*: </label>
									<select name="utilisateur" class="utilisateur-select">';
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo '					<option value="'.$row['id'].'">'.$row['login'].'</option>';
			}
		}
		echo '						</select>
								</div>
								<div style="margin-left: 10px;">
									<label for="quiz-select">Choisir un quiz*: </label>
									<select name="quiz" class="quiz-select">';
		if($result1->num_rows > 0) {
			while ($row1 = $result1->fetch_assoc()) {
				echo '					<option value="'.$row1['nom_quiz'].'">'.$row1['nom_quiz'].'</option>';
			}
		}
		echo '						</select>
								</div>
								<div class="button">
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