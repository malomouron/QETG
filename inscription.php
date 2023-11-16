<?php
	session_start();
	include ('functions.php');
	$chaine = Genere_Password(75);

    $key_password = "Mal0_av3c_Une_Cle_hyper_S3cure!z";
    $encrypted_chaine = openssl_encrypt($chaine, "AES-128-ECB" ,$key_password);
	
	echo '  <!DOCTYPE html>
			<html>
				<head>';
			
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Inscription", $css, "UTF-8");
			
	echo'</head>
				<body>';
	include ('bandeau.php');
	echo'			<div>
						<div id="inscription-menu-gauche">
						</div>
						<div id="inscription-div1">
							<h1 id="inscription-h1">Inscription à l\'espace membre :</h1>
							<br />
							<p id="inscription-p-titre">';
	if (isset($_SESSION['erreur']) && $_SESSION['debug'] == 1) echo '<br />',$_SESSION['erreur'];
	echo'					</p>
							<form action="email_confirmation.php" method="post" id="inscription-form1" name="form1">
								<label class="inscription-label-glob" for="login">Login : </label><input class="inscription-input-glob" type="text" name="login" value="';
	if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); 
	echo						'" required>
								<div id="inscription-form-div-label">
									<label class="inscription-label-glob" id="inscription-form-div-label-num1" for="nom">Nom : </label><input class="inscription-input-glob" id="inscription-form-div-input1" type="text" name="nom" value="';
	if (isset($_POST['nom'])) echo htmlentities(trim($_POST['nom']));
	echo						'" required>
									<label class="inscription-label-glob" id="inscription-form-div-label-num2" for="prenom">Prénom : </label><input class="inscription-input-glob" id="inscription-form-div-input2" type="text" name="prenom" value="';
	if (isset($_POST['prenom'])) echo htmlentities(trim($_POST['prenom']));
	echo						'" required>
								</div>
								<label class="inscription-label-glob" for="email">Adresse email: </label><input class="inscription-input-glob" type="email" name="email" value="';
	if (isset($_POST['email'])) echo htmlentities(trim($_POST['email']));
	echo						'" required>
								<label class="inscription-label-glob" for="pass">Mot de passe : </label><input class="inscription-input-glob" type="password" name="pass" value="';
	if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass']));
	echo						'" required>
								<img class="inscription-show-password" id="inscription-monImage" src="commun/oeil_cache.png"/>
								<label class="inscription-label-glob" for="pass_confirm">Mot de passe : </label><input class="inscription-input-glob" type="password" name="pass_confirm" value="';
	if (isset($_POST['pass_confirm'])) echo htmlentities(trim($_POST['pass_confirm']));
	echo						'" required>
								<img class="inscription-show-password2" id="inscription-monImage2" src="commun/oeil_cache.png"/>
								<label class="inscription-label-glob" for="newletter">recevoir des newsletter : </label><input class="inscription-input-glob" type="checkbox" name="newletter" value="1">
								<div class="g-recaptcha" data-callback data-sitekey="';
	echo $site_key;
	echo						'" data-theme="dark"></div>
								<input type="hidden" name="key" value="'.$encrypted_chaine.'">
								<div class="inscription-button">
									<input class="inscription-input-glob" type="submit" name="inscription" value="Inscription" id="inscription-id-bt">
								</div>
							</form>
						</div>
						<div id="inscription-menu-droit">
						</div>
					</div>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
					<script type="text/javascript">
						$(document).ready(function(){
							$(\'.inscription-show-password\').click(function() {
								if($(this).prev(\'input\').prop(\'type\') == \'password\') {
									//Si c\'est un input type password
									$(this).prev(\'input\').prop(\'type\',\'text\');
									$(\'#inscription-monImage\').attr(\'src\',\'commun/oeil.png\');
								} else {
									//Sinon
									$(this).prev(\'input\').prop(\'type\',\'password\');
									$(\'#inscription-monImage\').attr(\'src\',\'commun/oeil_cache.png\');
								}
							});
						});
					</script>
					<script type="text/javascript">
						$(document).ready(function(){
							$(\'.inscription-show-password2\').click(function() {
								if($(this).prev(\'input\').prop(\'type\') == \'password\') {
									//Si c\'est un input type password
									$(this).prev(\'input\').prop(\'type\',\'text\');
									$(\'#inscription-monImage2\').attr(\'src\',\'commun/oeil.png\');
								} else {
									//Sinon
									$(this).prev(\'input\').prop(\'type\',\'password\');
									$(\'#inscription-monImage2\').attr(\'src\',\'commun/oeil_cache.png\');
								}
							});
						});
					</script>
				</body>
			</html>';
	$_SESSION['debug'] = 0
?>