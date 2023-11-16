<?php 
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if (isset($_SESSION['id'])) {
		$select_compter_nbr_quiz_effectué =  $db->query("SELECT count(*) nombre FROM quiz_statistique WHERE quiz_utilisateur = 0 and id_user = ".$_SESSION['id'])->fetchArray();
	}
	$select_nbr_quiz =  $db->query("SELECT COUNT(*) nombre_de_quiz FROM quiz WHERE id_quiz_user = 0")->fetchArray();
?>
<!DOCTYPE html>
<html>
	<head>
<?php
	$css = array("css.css", "commun/bandeau.css");
	afficher_head("Le quiz en tous genre", $css, "UTF-8");
?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function onSubmit(token) {
                document.getElementById("demo-form").submit();
            }
        </script>
	</head>
	<body>
		<div id="global">
<?php 
	include ("commun/bandeau.php");
?>
			<nav id="nav1" role="navigation">
				<div id="menuToggle">
					<input class="index-input" id="menuToggle-input" type="checkbox" />
					<span></span>
					<span></span>
					<span></span>
					<ul id="menu-gg-burg">
<?php
	if (isset($_SESSION['login'])) {
		echo '<a href="#" id="togg3"><li>Déconnexion</li></a>';
	} else {
		echo '	<a href="identifier.php"><li>S\'identifier</li></a>
				<a href="inscription.php"><li>Créer un compte</li></a>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<a href="admin.php"><li>Administrateur</li></a>';
	}
	if (isset($_SESSION['login'])) {
		echo '<a href="profil.php"><li><img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">Profil</li></a>';
	}
?>
						<a href="quiz_utilisateur.php"><li>Quiz utilisateur</li></a>
						<a href="poster_quiz.php"><li>Poster des quiz</li></a>
						<a href="/lien-bandeau/"><li>À propos de Quiz dans tout genre</li></a>
						<a href="aide-page.php"><li>Aide</li></a>
					</ul>
				</div>
			</nav>
			<nav id="nav2" role="navigation">
				<div id="menuToggle">
					<input class="index-input" id="menuToggle-input" type="checkbox" />
					<span></span>
					<span></span>
					<span></span>
					<ul id="menu-gg-burg">
						<form class="form-search-bis" action="search.php" method="get">
							<input class="index-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
							<svg viewBox="0 0 512 512">
								<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
							</svg>
						</form>
<?php
	if (isset($_SESSION['login'])) {
		echo '<a href="#" id="togg4"><li>Déconnexion</li></a>';
	} else {
		echo '	<a href="identifier.php"><li>S\'identifier</li></a>
				<a href="inscription.php"><li>Créer un compte</li></a>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<a href="admin.php"><li>Administrateur</li></a>';
	}
	if (isset($_SESSION['login'])) {
		echo '<a href="profil.php"><li><img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">Profil</li></a>';
	}
?>
                        <a href="quiz_utilisateur.php"><li>Quiz utilisateur</li></a>
                        <a href="poster_quiz.php"><li>Poster des quiz</li></a>
						<a href="/quiz/lien-bandeau/"><li>À propos de Quiz dans tout genre</li></a>
						<a href="aide-page.php"><li>Aide</li></a>
					</ul>
				</div>
			</nav>
			<div id="menu-gauche">
				<p class="transp">ester egg</p>
<?php
	if (isset($_SESSION['login'])) {
		echo '<div id="decon">
					<button class="index-button" id="togg1">
						<span id="decon-int" class="myButton">Déconnexion</span>
					</button>
				</div>';
	} else {
		echo '<div id="ident">
					<div>
						<a id="id-int-ident" class="myButton" href="identifier.php">S\'identifier</a>
					</div>
					<div>
						<a href="inscription.php" class="myButton">Créer un compte</a>
					</div>
				</div>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<div id="admin-div">
					<a id="admin-div-int" class="myButton" href="admin.php">Administrateur</a>
				</div>';
	}
	if (isset($_SESSION['login'])) {
		echo '<div class="div-a-2" id="div-prof-glob">
					<a id="div-prof-int" class="myButton" href="profil.php">
						<img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">
						<span id="texte-prof-int">Profil</span>
					</a>
				</div>';
	}
?>
			<div style="position: fixed;margin:23.386% 0 0 6%;">
				<a href="aide-page.php">
					<img src="commun/bouton-aide.png" alt="bouton aide" style="width:50px;height:50px;">
				</a>
			</div>
			</div>
			<div id="index-div1">
				<div id="d1">
					<div id="d1-int">
						<button class="index-button" id="togg2">
							X
						</button>
					</div>
					<div id="id-int-deco-pag">
						<h2 id="id-int-deco-h2">Êtes vous sur de vouloir vous déconnecter ?</h2>
						<br><br><br>
						<b id="b-deco-int">
							<a href="deconnexion.php" id="a-deco-int">Oui</a>
							<a href="index.php" id="a-deco-int-2">Non</a>
						</b>
					</div>
				</div>
				<h1 id="bien-debu">Bienvenue 
<?php 
	if (isset($_SESSION['login'])) {
		echo $_SESSION['login'];
	}
?>
 dans ce site qui réunit des quiz en tout genre</h1>
				<p>Ci-dessous vous pouvez accéder à plein de quiz divers</p>
<?php

	if(!isset($_REQUEST['page'])){
		$_REQUEST['page'] = 1;
	}	
	$select_tout_quiz = $db->query('SELECT quiz.id_quiz, quiz_image.alt, quiz_image.src, quiz.nom_quiz, quiz.bienvenue FROM quiz, quiz_image where quiz.id_quiz_user = 0 AND quiz.id_image_quiz = quiz_image.id_image')->fetchAll();
	$_SESSION['auth'] = 1;
	if (count($select_tout_quiz) > 0) {
// output data of each row
		foreach($select_tout_quiz as $cle => $row) {
			$calculeCle_2 = $nombreDeQuizAfficher * $_REQUEST['page'];
			$claculeCle = $calculeCle_2 - $nombreDeQuizAfficher;
			if ($cle < $calculeCle_2 AND $cle >= $claculeCle){
				if (isset($_SESSION['login'])) {
					$select_tout_quiz_favori = $db->query("SELECT quiz_statistique.id_quiz, quiz.nom_quiz, quiz.id_quiz, quiz_statistique.date, quiz_statistique.favoris FROM quiz_statistique, quiz WHERE quiz_statistique.id_user = ".$_SESSION['id']." and quiz_statistique.id_quiz = quiz.id_quiz and quiz.id_quiz = ".$row['id_quiz'])->fetchArray();
				}
				$slect_nbr_like_quiz = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$row['id_quiz'])->fetchArray();
				$slect_nbr_dis_quiz = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$row['id_quiz'])->fetchArray();
				
				$slect_nbr_like_quiz_user = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$row['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
				$slect_nbr_dis_quiz_user = $db->query("SELECT count(*) nbr_dis_ip FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$row['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
				if (isset($_SESSION['login']) AND $select_tout_quiz_favori['favoris'] == 1) {
					echo '	<div class="entre-quiz">
								<a href="Quiz-presentation.php?id_quiz='.$row["id_quiz"].'">
									<img class="image-entre-du-quiz" id="entre-quiz-img-3" src="'.$row["src"].'" alt="'.$row["alt"].'">
									<br>
								</a>
								'.$slect_nbr_like_quiz['nbr_like'].'
								<a href="likedislike.php?l=1&q='.$row['id_quiz'].'">
									<svg ';
					if($slect_nbr_like_quiz_user['nbr_like_ip'] > 0){
						echo 'style="fill: blue;"';
					}
					echo				' class="index-svg-like" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
								</a>
								'.$slect_nbr_dis_quiz['nbr_dis'].'
								<a href="likedislike.php?l=0&q='.$row['id_quiz'].'">
									<svg ';
					if($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0){
						echo 'style="fill: red;"';
					}
					echo				' class="index-svg-dislike" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
								</a>
								<a href="Quiz-presentation.php?id_quiz='.$row["id_quiz"].'">
									<span class="lien-texte">'.$row["nom_quiz"].'</span>
								</a>
									<img id="entre-quiz-img-fav-2" src="commun/favori-rempli.PNG" alt="favoris">
							</div>';
				} else {
					echo '	<div class="entre-quiz">
								<a href="Quiz-presentation.php?id_quiz='.$row["id_quiz"].'">
									<img class="image-entre-du-quiz" id="entre-quiz-img-4" src="'.$row["src"].'" alt="'.$row["alt"].'">
									<br>
								</a>
								'.$slect_nbr_like_quiz['nbr_like'].'
								<a href="likedislike.php?l=1&q='.$row['id_quiz'].'">
									<svg ';
					if($slect_nbr_like_quiz_user['nbr_like_ip'] > 0){
						echo 'style="fill: blue;"';
					}
					echo				' class="index-svg-like" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
								</a>
								'.$slect_nbr_dis_quiz['nbr_dis'].'
								<a href="likedislike.php?l=0&q='.$row['id_quiz'].'">
									<svg ';
					if($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0){
						echo 'style="fill: red;"';
					}
					echo				' class="index-svg-dislike" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
								</a>
								<a href="Quiz-presentation.php?id_quiz='.$row["id_quiz"].'">
									<span class="lien-texte">'.$row["nom_quiz"].'</span>
								</a>
							</div>';
				}
			}
		}
	} else {
		echo "pas de quiz";
	}
	

	echo 		'<div>
					<a id="poster_quiz_id" href="';
	if(isset($_SESSION['login'])){
		echo 'poster_quiz.php';
	}else{
		echo 'identifier.php';
	}
	echo '" class="myButton">Poster des quiz</a>
				</div>';
	echo 		'<div>
					<a id="poster_quiz_id" href="';
	if(isset($_SESSION['login'])){
		echo 'quiz_utilisateur.php';
	}else{
		echo 'quiz_utilisateur.php';
	}
	echo '" class="myButton">Quiz utilisateur</a>
				</div>
				<ul class="ul">
					<li class="page-item">
						<a class="page-link" href="?page=';
	if ($_REQUEST['page'] != 1){
		echo $_REQUEST['page'] - 1;
	}else{
		echo $_REQUEST['page'];
	}
	$suivant=$_REQUEST['page']+1;
	echo 				'">Précédente</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page=1">1</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page=2">2</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page=3">3</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page=4">4</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page='.$suivant.'">Suivante</a>
					</li>
				</ul>
				<hr width="100%" color="black" size="3">';
	
	if(isset($_SESSION['login'])){
		$select_membre_info = $db->query("SELECT * FROM quiz_membre where login = '".$_SESSION['login']."'")->fetchArray();
		echo '		<form action="envoyer-mail.php" method="post" id="form">
						<h2 id="form-mail-com">Commentaire : </h2>
						<div class="div_alig_connect">
	<label class="index-label" for="name">Nom*:</label> <input class="index-input" type="hidden" id="user_name" name="user_name" value="'.$select_membre_info['nom'].' ( '.$_SESSION['login'].' )" required><span>'.$select_membre_info['nom'].' ( '.$_SESSION['login'].' )</span>
						</div>
						<div class="div_alig_connect">
							<label class="index-label" for="prenom">Prénom*:</label> <input class="index-input" type="hidden" id="user_prenom" name="user_prenom" value="'.$select_membre_info['prenom'].'" required><span>'.$select_membre_info['prenom'].'</span>
						</div>
						<div class="div_alig_connect">
							<label class="index-label" for="mail">E-mail*:</label> <input class="index-input" type="hidden" id="user_mail" value="'.$select_membre_info['email'].'" name="user_mail" required><span>'.$select_membre_info['email'].'</span>
						</div>
						<div>
							<label class="index-label" for="msg">Message*:</label> <textarea class="index-textarea" id="user_message" name="user_message" required></textarea>
						</div>
						<div class="g-recaptcha" data-callback data-sitekey="'.$site_key.'" data-theme="dark"></div>
						<div class="button">
							<input class="index-input" type="submit" value="Submit" id="id-bt">
						</div>
					</form>';
	}else {
		echo '		<form action="envoyer-mail.php" method="post" id="form">
						<h2 id="form-mail-com">Commentaire : </h2>
						<div>
							<label class="index-label" for="name">Nom*:</label> <input class="index-input" type="text" id="user_name" name="user_name" required>
						</div>
						<div>
							<label class="index-label" for="prenom">Prénom*:</label> <input class="index-input" type="text" id="user_prenom" name="user_prenom" required>
						</div>
						<div>
							<label class="index-label" for="mail">E-mail*:</label> <input class="index-input" type="email" id="user_mail" name="user_mail" required>
						</div>
						<div>
							<label class="index-label" for="msg">Message*:</label> <textarea class="index-textarea" id="user_message" name="user_message" required></textarea>
						</div>
						<button class="g-recaptcha" 
                            data-sitekey="'.$site_key.'" 
                            data-callback=\'onSubmit\' 
                            data-action=\'submit\'>Submit</button>
						<div class="button">
							<input class="index-input" type="submit" value="Submit" id="id-bt">
						</div>
					</form>';
	}
?>
				<br><br><br><br>
				<?php
		require ('afficher-commentaire.php');
				?>
				<br><br><br><br>
			</div>
			<div id="menu-droit">
				<div>
					<form action="search.php" method="get" id="form-search-quiz">
						<div id="form-search-quiz-int">
							<input class="index-input" type="text" name="search" placeholder="Recherche..." id="form-search-quiz-int-input" autocomplete="off" value="">
							<svg viewBox="0 0 512 512" id="form-search-quiz-int-svg">
								<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
							</svg>
						</div>
					</form>
				</div>
<?php
	if (isset($_SESSION['login'], $select_compter_nbr_quiz_effectué['nombre'])) {
		echo	'<div id="div-jauge">
					<h2 id="div-jauge-h2">Vous avez effectué <br> '.$select_compter_nbr_quiz_effectué["nombre"].' /'.$select_nbr_quiz['nombre_de_quiz'].' quiz</h2>
					<progress id="jauge" min="0" max="'.$select_nbr_quiz['nombre_de_quiz'].'"></progress>
					<script type="text/javascript">
						var timer = setInterval(jaugeUpdate, 1000);
						function jaugeUpdate(){
							var level =  '.$select_compter_nbr_quiz_effectué["nombre"].' ;
							document.getElementById(\'jauge\').value = level;
						}
					</script>
				</div>';
	} else {
		if (!isset($_SESSION['login'])) {
			echo	'<div id="div-jauge-3">
						<h2 id="div-jauge-h2-3">Si vous voulez avoir accès aux statistiques vous devez vous connecter!</h2>
					</div>';
		}
	}
?>
			</div>
<?php
	if (isset($_SESSION['login'], $select_compter_nbr_quiz_effectué['nombre'])) {
		echo	'<div id="div-jauge-bis">
					<p>Vous avez effectué '.$select_compter_nbr_quiz_effectué["nombre"].' /'.$select_nbr_quiz['nombre_de_quiz'].' quiz</p>
					<progress id="jauge-bis" min="0" max="'.$select_nbr_quiz['nombre_de_quiz'].'"></progress>
					<script type="text/javascript">
						var timer = setInterval(jaugeUpdate, 1000);
						function jaugeUpdate(){
							var level =  '.$select_compter_nbr_quiz_effectué["nombre"].' ;
							document.getElementById(\'jauge-bis\').value = level;
						}
					</script>
				</div>';
	} else {
		if (!isset($_SESSION['login'])) {
			echo	'<div id="div-jauge-2-bis">
						<p>Si vous voulez avoir accès aux statistiques vous devez vous connecter!</p>
					</div>';
		}
	}
	//include ('footer.php');
?>
			<footer id="footer">
				<p>Créé par Malo MOURON<br>Copyright © 2018 malomouron.fr Tous droits réservés.<br>N'hésitez pas à partager ce lien à vos proches et à vos amis : <br><img src="commun/index-image.png" id="img-index-1"><a id="lien-frama" href="http://malomouron.fr" target="_blank">malomouron.fr</a><img id="img-index-2" src="commun/index-image2.png"></p>
				<a href="lien-bandeau/" class="cop-id-lien">À propos de Quiz en tout genre</a>
				<a href="lien-bandeau/#2" class="cop-id-lien">Contacts</a>
				<a href="lien-bandeau/#3" class="cop-id-lien">Avertissements</a>
				<a href="lien-bandeau/#4" class="cop-id-lien">Cookies</a>
				<a href="lien-bandeau/#5" class="cop-id-lien">Politique de confidentialité</a>
				<a href="../projet.php" id="cop-id-lien-1">Mes projets</a>
			</footer>
			<script type="text/javascript">
				let togg1 = document.getElementById("togg1");
				let togg2 = document.getElementById("togg2");
				let togg3 = document.getElementById("togg3");
				let togg4 = document.getElementById("togg4");
				let d1 = document.getElementById("d1");
				let d2 = document.getElementById("d2");
				togg1.addEventListener("click", () => {
				if(getComputedStyle(d1).display != "none"){
					d1.style.display = "none";
				} else {
					d1.style.display = "block";
				}
				})
				
				togg3.addEventListener("click", () => {
				if(getComputedStyle(d1).display != "none"){
					d1.style.display = "none";
				} else {
					d1.style.display = "block";
				}
				})
				
				togg4.addEventListener("click", () => {
				if(getComputedStyle(d1).display != "none"){
					d1.style.display = "none";
				} else {
					d1.style.display = "block";
				}
				})
				
				function togg(){
				if(getComputedStyle(d1).display != "none"){
					d1.style.display = "none";
				} else {
					d1.style.display = "block";
				}
				};
				togg2.onclick = togg;
				function affich_rep_comm(id){
				    var div_comm = document.getElementById("reponse_comm_"+id);
				    var img_comm = document.getElementById("img_reponse_comm_"+id);
                    if (div_comm.style.display == "none"){
                        div_comm.style.display = "block";
                        img_comm.src = "commun/rep_comm_masq.png";
                    }else{
                        div_comm.style.display = "none";
                        img_comm.src = "commun/rep_comm.png";
                    }
                }
			</script>
		</div>
	</body>
</html>