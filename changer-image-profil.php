<?php 
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if(isset($_POST['avatar_perso'])) {
		$nomOrigine = $_FILES['avatar']['name'];
		$elementsChemin = pathinfo($nomOrigine);
		$extensionFichier = $elementsChemin['extension'];
		$extensionsAutorisees = array("jpeg", "jpg", "gif", "tiff", "bmp", "svg", "png");
		if (!(in_array($extensionFichier, $extensionsAutorisees))) {
			echo "Le fichier n'a pas l'extension attendue";
		} else {
			// Copie dans le repertoire du script avec un nom
			// incluant l'heure a la seconde pres 
			if ($os == "windos") {
				$repertoireDestination = dirname(__FILE__)."\\image-profil\\image-personaliser\\";
			} else {
				$repertoireDestination = dirname(__FILE__)."/image-profil/image-personaliser/";
			}
			$nomDestination = "fichier_du_".date("Y-m-d-H-i-s")."_par_".$_SESSION['id'];
		
			if (move_uploaded_file($_FILES["avatar"]["tmp_name"], 
											$repertoireDestination.$nomDestination)) {
				echo "Le fichier temporaire ".$_FILES["avatar"]["tmp_name"].
						" a été déplacé vers ".$repertoireDestination.$nomDestination;
				$update_img_prof_file = $db->query('UPDATE quiz_membre SET image_profil = "image-profil/image-personaliser/'.$nomDestination.'" WHERE id = '.$_SESSION['id']);
			} else {
				echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
						"Le déplacement du fichier temporaire a échoué".
						" vérifiez l'existence du répertoire ".$repertoireDestination;
			}
		}
	} elseif (isset($_POST['select-img-profil-dev']) AND !isset($_POST['avatar_perso'])) {
		$update_img_prof_liste  = $db->query('UPDATE quiz_membre SET image_profil = "image-profil/'.$_POST['select-img-profil-dev'].'" WHERE id = '.$_SESSION['id']);
	}
	include ('footer.php');
	header('Location: profil.php');
?>