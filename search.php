<?php 
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	$selete_recherche_user = $db->query("SELECT * FROM quiz, quiz_image WHERE ( nom_quiz LIKE '%".$_REQUEST['search']."%' ) AND quiz.id_image_quiz = quiz_image.id_image")->fetchAll();
	if (count($selete_recherche_user) > 0) {
		echo	'	<!DOCTYPE html>
					<html>
						<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Recherche", $css, "UTF-8");
		echo'			</head>
						<body>';
		include ("bandeau.php");
		echo'				<div id="search-div1">
								<form class="search-form" action="search.php" method="get">
									<div class="search-div-rchrch">
										<label class="search-label" for="search-quiz"></label>
										<input class="search-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
										<svg class="search-svg" viewBox="0 0 512 512">
											<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
										</svg>
									</div>
								</form>';
		foreach($selete_recherche_user as $row) {
			echo '				<a href="Quiz-presentation.php?id_quiz='.$row["id_quiz"].'">
									<div id="search-div">
										<img id="search-img-pre" src="'.$row['src'].'" alt="'.$row['alt'].'">
										<div id="search-div-img">
											<h2 id="search-h2">'.$row['nom_quiz'].'</h2>
										</div>
										<b id="search-b1">+'.$row['xp'].' xp</b>
									</div>
								</a>
								<hr>';
		}
		echo '				</div>
						</body>
					</html>';
	} elseif (count($selete_recherche_user) == 0) {
		include ('bandeau.php');
		echo	'	<!DOCTYPE html>
					<html>
						<head>';
		$css = array("css.css", "commun/bandeau.css");
		afficher_head("Recherche", $css, "UTF-8");
		echo'			</head>
						<body>';
		include ("bandeau.php");
		echo'				<div id="search-div1">
								<form class="search-form" action="search.php" method="get">
									<div class="search-div-rchrch">
										<label class="search-label" for="search-quiz"></label>
										<input class="search-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
										<svg class="search-svg" viewBox="0 0 512 512">
											<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
										</svg>
									</div>
								</form>
								<h1 id="search-h1">Nous n\'avons rien trouvé qui correspond à votre recherche</h1>
							</div>
						</body>
					</html>';
	}
	include ('footer.php');
?>