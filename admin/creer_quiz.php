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
		
		echo '	<!DOCTYPE html>
				<html>
					<head>';
		include ('../functions.php');
		$css = array("CSS.css", "../commun/bandeau-admin.css");
		afficher_head("Créer un quiz", $css, "UTF-8");
		echo'			<script language="JavaScript">
							function afficherAutre() {
								var a = document.getElementById("url_quiz");
								var m = document.getElementById("url_quiz1");
								var c = document.getElementById("url_quiz2");
								
								if (document.form1.liste.value == 2)
								{
									if (a.style.display == "none")
										a.style.display = "inline";
								
									if (m.style.display == "none")
										m.style.display = "inline";
									
									if (c.style.display == "none")
										c.style.display = "contents";
								}
								else
								{
									a.style.display = "none";
									m.style.display = "none";
									c.style.display = "none";
								}
							}
						</script>
					</head>
					<body>
						<div id="div1">
							<h1>Créer un quiz</h1>
							<h2 style="font-size:20px;color:red;">Ajouter une image avant de créer un quiz!</h2>
							<form action="action-form/creer-quiz-2.php" method="post" id="form" name="form1">
								<div style="margin-left: -35px;">
									<label for="image-select">Choisir une image*: </label>
									<select name="image" class="image-select">';
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo '					<option value="'.$row['src'].'">'.$row['src'].'</option>';
			}
		}
		echo '						</select>
								</div>
								<div style="margin-left: -140px;">
									<label for="nom_quiz">Nom du quiz*: </label>
									<h6 style="display: contents;">(exemple : quiz HTML)</h6>
									<input type="text" id="nom_quiz" name="nom_quiz" required>
								</div>
								<div style="margin-left: -239px;">
									<label for="bienvenue">Message de bienvenue*: </label>
									<h6 style="display: contents;">(exemple : Bienvenu dans un quiz d\'HTML5)</h6>
									<input type="text" id="bienvenue" name="bienvenue" required>
								</div>
								<div style="margin-left: -97px;">
									<label for="xp">Gain d\'xp*: </label>
									<h6 style="display: contents;">(exemple : 10)</h6>
									<input type="number" id="xp" name="xp" required>
								</div>
								<div style="display: flex;margin-left: 141px;">
									<label for="image-select">Voulez vous ajouter un URL : </label>
									<select name="liste" onChange="afficherAutre()" class="image-select">
										<option value=1>Non</option>
										<option value=2>Oui</option>
									</select>
									<br>
								</div>
								<div style="display: flex;margin-left: -164px;">
									<label id="url_quiz" style="display: none" for="url_quiz">Url du quiz : </label>
									<h6 style="display: none;" id="url_quiz2">(exemple : Quiz-HTML/Quiz-presentation/Quiz-presentation.php)</h6>
									<input type="text" id="url_quiz1" name="url_quiz1" style="display: none;">
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