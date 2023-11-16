<?php include ('functions.php'); ?>
<!DOCTYPE>
<html>
	<head>
<?php
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Mot de pass oublier", $css, "UTF-8");
?>
	</head>
	<body>
		<?php include ("bandeau.php"); ?>
		<div id="mot-pass-oublier-div1">
			<h1>Changer de mot de pass</h1>
			<form action="changer.php" method="post" id="mot-pass-oublier-form">
				<div>
					<label id="mot-pass-oublier-label" for="email">Veuillez entrer votre email</label>
					<input class="mot-pass-oublier-input" name="email" type="email" required>
				</div>
				<div class="mot-pass-oublier-button">
					<input class="mot-pass-oublier-input" type="submit" name="changer" value="Continuer" id="mot-pass-oublier-id-bt">
				</div>
			</form>
		</div>
	</body>
</html>