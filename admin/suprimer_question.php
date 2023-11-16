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
		
		$sql = "SELECT question_texte, id_question FROM question";
		$result1 = $conn->query($sql);
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Suprimer une question", $css, "UTF-8");
		echo'		</head>
					<body>
						<div id="div1">
							<h1>Suprimer une question</h1>
							<form action="action-form/suprimer-question-2.php" method="post" id="form" name="form1">
								<div style="margin-left: -216px;">
									<label for="question-select">Choisir une question*: </label>
									<select name="question" class="question-select" id="select">';
		if($result1->num_rows > 0) {
			while ($row1 = $result1->fetch_assoc()) {
				echo '					<option value="'.$row1['id_question'].'">'.$row1['question_texte'].'</option>';
			}
		}
		echo '						</select>
								</div>
								<div class="button">
									<input type="submit" value="Suprimer" id="id-bt">
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