<?php
	session_start();
	include ('functions.php');
	$db = new db($dbhost, $dbuser, $dbpass, $dbname);
	if (isset($_SESSION['login']) and !isset($_GET['u'])) {
		$xp = 0;
		$level = 1;
		$select_quiz_effectué = $db->query("SELECT * FROM quiz_statistique, quiz, quiz_image WHERE quiz.id_image_quiz = quiz_image.id_image AND quiz.id_quiz_user = 0 AND quiz_statistique.id_user = ".$_SESSION['id']." and quiz_statistique.id_quiz = quiz.id_quiz ORDER BY `quiz_statistique`.`favoris` DESC")->fetchAll();
		$selct_quiz_pour_xp = $db->query("SELECT quiz.xp, quiz_statistique.id_user, quiz_statistique.id_quiz FROM quiz_statistique, quiz WHERE quiz_statistique.id_user = ".$_SESSION['id']." and quiz.id_quiz = quiz_statistique.id_quiz")->fetchAll();
		$selct_succes_pour_xp = $db->query("SELECT * FROM quiz_membre_succes, quiz_succes WHERE quiz_membre_succes.id_membre = ".$_SESSION['id']." and quiz_membre_succes.id_succes = quiz_succes.id_succes")->fetchAll();
		$selct_le_membre_connecté = $db->query("SELECT * FROM `quiz_membre` WHERE id = ".$_SESSION['id'])->fetchArray();
		if (count($selct_quiz_pour_xp) > 0) {
			foreach($selct_quiz_pour_xp as $row2) {
				$xp =  $xp + $row2['xp'];
			}
		}
		if (count($selct_succes_pour_xp) > 0) {
			foreach($selct_succes_pour_xp as $row2) {
				$xp =  $xp + $row2['xp_succes'];
			}
		}
        $level = intdiv($xp,15)+1;
		if ($level >= 10){
            succes($_SESSION['id'],5,$db);
        }
		$xpbis = $xp-(($level-1)*15) ;
		$selct_les_sucsses_du_membre = $db->query("SELECT quiz_succes.nom_succes, quiz_succes.xp_succes, quiz_succes.descri_succes, quiz_membre_succes.id_succes, quiz_membre_succes.date_succes FROM quiz_succes, quiz_membre_succes WHERE ".$_SESSION['id']." = quiz_membre_succes.id_membre AND quiz_membre_succes.id_succes = quiz_succes.id_succes")->fetchAll();
		echo	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("profil.css", "commun/bandeau.css", "css.css");
		afficher_head("Profil", $css, "UTF-8");
		echo'			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
						<script language="JavaScript">
							function afficherChangerImage() {
								var a = document.getElementById("img-prof");
								
								if (document.form1.liste.value == 2)
								{
									if (a.style.display == "none")
										a.style.display = "inline";
								}
								else
								{
									a.style.display = "none";
								}
							}
						</script>
						<script type="text/javascript">
							function verif ()
							{
								var etat = document.getElementById(\'check\').checked;
								
								if(etat)
								{
									document.getElementById(\'1\').className = \'dev\';
									
									document.getElementById(\'2\').className = \'uti\';
								}
								else
								{
									document.getElementById(\'1\').className = \'uti\';
									
									document.getElementById(\'2\').className = \'dev\';
								}
							}
						</script>
						<style type="text/css">
							.uti {
								display: block;
							}
							
							.dev {
								display: none;
							}
						</style>
						<link rel="stylesheet" type="text/css" href="commun/image-picker/image-picker.css">
						<script src="commun/image-picker/image-picker.js" type="text/javascript"></script>
						<script type="text/javascript">
                            function lang_change(){
                                var select_lang = document.getElementById("lang").value;
                                if(select_lang == "fr"){
                                    window.location.href = "https://malomouron.fr/quiz/index.php";
                                }else{
                                    window.location.href = "https://malomouron-fr.translate.goog/quiz/index.php?_x_tr_sl=fr&_x_tr_tl="+select_lang;
                                }
                            }
						</script>
					</head>
					<body>';
		include ("bandeau.php");
		echo'			<a id="lien-paypal" href="https://paypal.me/MaloMouron" target="_blank">
							<img id="img-paypal" src="commun/don.png" alt="logo don paypal" class="div-a-2">
						</a>';
		echo'			<div id="div1">
							<div id="d2" style="display:none;">
								<div id="div-img-changer">
									<button class="button-all" id="togg2" id="button-id-X">
										X
									</button>
								</div>
								<div id="div-int-id-bis">
									<h2 id="h2-changer-bis">Changer l\'image de profil</h2>
									<form enctype="multipart/form-data" for="form1" action="changer-image-profil.php" method="post">
										<label class="label-all" for="avatar_perso">Utiliser un avatar personnalisé</label>
										<div id="div-inline-multi">
											<input class="input-all" class="auto-width" id="check" checked type="checkbox" onChange="verif();" name="avatar_perso" value="oui">
											<label class="auto-width">oui</label>
										</div>
										<br>
										<div class="dev" id="1">
											<label class="label-all" for="select-img-profil-dev" >Sélectioner une image de profil : </label>
											<select name="select-img-profil-dev" class="image-picker show-labels show-html">
												<option value=""></option>
												<option data-img-src="image-profil/30000_m.png" valeur="30000_m.png">30000_m.png</option>
												<option data-img-src="image-profil/30002_m.png" valeur="30002_m.png">30002_m.png</option>
												<option data-img-src="image-profil/30004_m.png" valeur="30004_m.png">30004_m.png</option>
												<option data-img-src="image-profil/E0016_m.png" valeur="E0016_m.png">E0016_m.png</option>
												<option data-img-src="image-profil/E0029_m.png" valeur="E0029_m.png">E0029_m.png</option>
												<option data-img-src="image-profil/EP40091107034_8C197C9A01BB8A11C8C8_M.png" valeur="EP40091107034_8C197C9A01BB8A11C8C8_M.png">EP40091107034_8C197C9A01BB8A11C8C8_M.png</option>
												<option data-img-src="image-profil/EP40091107035_186878B435F63EB561CA_M.png" valeur="EP40091107035_186878B435F63EB561CA_M.png">EP40091107035_186878B435F63EB561CA_M.png</option>
												<option data-img-src="image-profil/EP40091107036_4D29D152D7DE1092ED1A_M.png" valeur="EP40091107036_4D29D152D7DE1092ED1A_M.png">EP40091107036_4D29D152D7DE1092ED1A_M.png</option>
												<option data-img-src="image-profil/I0041_m.png" valeur="I0041_m.png">I0041_m.png</option>
												<option data-img-src="image-profil/I0042_m.png" valeur="I0042_m.png">I0042_m.png</option>
												<option data-img-src="image-profil/I0043_m.png" valeur="I0043_m.png">I0043_m.png</option>
												<option data-img-src="image-profil/I0044_m.png" valeur="I0044_m.png">I0044_m.png</option>
												<option data-img-src="image-profil/I0045_m.png" valeur="I0045_m.png">I0045_m.png</option>
												<option data-img-src="image-profil/IP91001401PR2_99ED763F79B9E245F073_M.png" valeur="IP91001401PR2_99ED763F79B9E245F073_M.png">IP91001401PR2_99ED763F79B9E245F073_M.png</option>
												<option data-img-src="image-profil/J0022_m.png" valeur="J0022_m.png">J0022_m.png</option>
												<option data-img-src="image-profil/J0036_m.png" valeur="J0036_m.png">J0036_m.png</option>
												<option data-img-src="image-profil/J0037_m.png" valeur="J0037_m.png">J0037_m.png</option>
												<option data-img-src="image-profil/J0038_m.png" valeur="J0038_m.png">J0038_m.png</option>
												<option data-img-src="image-profil/J0039_m.png" valeur="J0039_m.png">J0039_m.png</option>
												<option data-img-src="image-profil/J0044_m.png" valeur="J0044_m.png">J0044_m.png</option>
												<option data-img-src="image-profil/UP43611208W01_36B99D5D8BC0D8E4DF49_M.png" valeur="UP43611208W01_36B99D5D8BC0D8E4DF49_M.png">UP43611208W01_36B99D5D8BC0D8E4DF49_M.png</option>
											</select>
										</div>
										<script >
											$("select").imagepicker()
										</script>
										<div class="uti" id="2">
											<label class="label-all" id="label-uti-width" for="avatar">Téléverser un avatar personnalisé:</label>
											<input class="input-all" type="hidden" name="MAX_FILE_SIZE" value="200000" />
											<input id="input-uti-3" class="input-all" type="file" accept=".png,.jpg,.gif,.svg,.bmp,.tiff" name="avatar" onchange="this.blur()" title="Formats autorisés : JPEG, PNG, GIF">
										</div>
										<input id="input-confirm-bis" class="input-all" type="submit" value="Confirmer" class="id-bt">
									</form>
								</div>
							</div>
							<h1>Vous êtes sur le profil de '.$_SESSION['login'].'</h1>
							<div id="div-pre-h1">';
		if ($selct_le_membre_connecté['image_profil'] == "default"){
			echo				'<button class="button-all button_sans_default" id="togg1" style="-webkit-appearance: none;text-rendering: auto;color: transparent;letter-spacing: normal;word-spacing: normal;text-transform: none;text-indent: 0px;text-shadow: none;display: inline-block;text-align: center;cursor: pointer;background-color: transparent;box-sizing: initial;margin: 0em;padding: 0px 0px;border-width: 0px;border-style: solid;border-color: transparent;border-image: none;">
									<img class="lienAfficher" src="commun/vide-png.png" alt="image de profil" id="img-prof" style="cursor: pointer; max-width: 260px; min-width: 200px; min-height: 175px; max-height: 230px;">
								</button>';
		} else {
			echo				'<button class="button-all" id="togg1" style="-webkit-appearance: none;text-rendering: auto;color: transparent;letter-spacing: normal;word-spacing: normal;text-transform: none;text-indent: 0px;text-shadow: none;display: inline-block;text-align: center;cursor: pointer;background-color: transparent;box-sizing: initial;margin: 0em;padding: 0px 0px;border-width: 0px;border-style: solid;border-color: transparent;border-image: none;">
									<img src="'.$selct_le_membre_connecté['image_profil'].'" style="cursor: pointer;max-width: 217px;min-width: 200px;">
								</button>
								';
		}
		echo 					'<p><b id="b-niveau-descr">'.$_SESSION['login'].'</b><br><span id="span-niveau-descr">Niveau : <span id="span-niveau-descr-int">'.$level.'</span></span><br><span id="span-xp-descr">Expérience : '.$xpbis.'/15</span></p>
							</div>
							<a href="identifier.php" id="changer-util">Changer d\'utilisateur</a>
							<div id="div-table-bis">
								<table id="table-fav" class="table-all-td">
									<thead class="thead-all">
										<tr>
											<th id="th-colspan" colspan="9"><b>Tableau des quiz<b></th>
										</tr>
									</thead>
									<tbody class="tbody-all">
										<tr>
											<th rowspan="2" colspan="2" class="td-prem-fav" class="td-all"><b>Quiz Effectué : </b></th>
											<th rowspan="2" class="td-prem-fav" class="td-prem-fav-bis" class="td-all"><b>Date : </b></th>
											<th rowspan="2" class="td-prem-fav" class="td-prem-fav-bis" class="td-all"><b>Favoris : </b></th>
											<td id="info_tbl_quiz" colspan="5" class="td-prem-fav" class="td-prem-fav-bis" class="td-all"><b>Info : </b></td>
										</tr>
										<tr>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de question : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de vue : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>XP : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de like : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de dislike : </b></td>
										</tr>
									</tbody>
									<tfoot>';
		if (count($select_quiz_effectué) > 0) {
			foreach($select_quiz_effectué as $row1) {
				$select_nombre_de_question_pour_les_quiz_effectué = $db->query("SELECT COUNT(*) nombre_question FROM quiz_question where id_quiz = ".$row1['id_quiz'])->fetchArray();
				$select_nombre_de_like_pour_les_quiz_effectué = $db->query("SELECT *  FROM quiz_like_quiz where likeOrDislike = 1 AND id_quiz = ".$row1['id_quiz'])->numRows();
                $select_nombre_de_dislike_pour_les_quiz_effectué = $db->query("SELECT *  FROM quiz_like_quiz where likeOrDislike = 0 AND id_quiz = ".$row1['id_quiz'])->numRows();
                echo '					<tr>
                                            <td class="td-all" id="td-all-css-id">'.$row1['nom_quiz'].'</td>
											<td class="td-all" id="td-deusi-fav-1"><img id="img_profil_quiz" src="'.$row1['src'].'" alt="img presentation quiz"></td>
                                            <td class="td-all" class="td-all-css">'.$row1['date'].'</td>
                                            <td class="td-all" class="td-all-css">';
                if ($row1['favoris'] == 0) {
                    echo '	<a href="changer-en-favoris.php?id_quiz='.$row1['id_quiz'].'">
                                <img id="img-etoil-fav" src="commun/favori-vide.PNG" alt="non-favoris">
                            </a>';
                } elseif ($row1['favoris'] == 1) {
                    echo '	<a href="changer-en-non-favoris.php?id_quiz='.$row1['id_quiz'].'">
                                <img id="img-etoil-fav" src="commun/favori-rempli.PNG" alt="favoris">
                            </a>';
                }
                echo						'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_question_pour_les_quiz_effectué['nombre_question'].'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$row1['vue'].' vues</td>
                                            <td class="td-all" id="td-nbr-quest">+'.$row1['xp'].'xp</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_like_pour_les_quiz_effectué.'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_dislike_pour_les_quiz_effectué.'</td>
                                        </tr>';
			}
		}else{
			echo '<tr>
					<td id="td-deusi-fav-2" class="td-all" colspan="9">
						aucun quiz effectué
					</td>
				</tr>';
		}
				
		echo	'					</tfoot>
								</table>
							</div>
							<fieldset id="fieldset-prof">
								<legend>Succès</legend>
								<div>
									<table id="table-sucss">
										<tr id="first_tr_succses">
											<td class="td-sucss-ex" class="td-sucss">Nom du succès</td>
											<td class="td-sucss-ex" class="td-sucss">Description du succès</td>
											<td class="td-sucss-ex" class="td-sucss">Xp reporté</td>
											<td class="td-sucss-ex" class="td-sucss">Date</td>
										</tr>';
		if (count($selct_les_sucsses_du_membre) > 0) {
			foreach ($selct_les_sucsses_du_membre as $row_succ) {
				echo 				'	<tr>
											<td class="td-sucss">'.$row_succ['nom_succes'].'</td>
											<td class="td-sucss">'.$row_succ['descri_succes'].'</td>
											<td class="td-sucss">'.$row_succ['xp_succes'].'</td>
											<td class="td-sucss">'.$row_succ['date_succes'].'</td>
										</tr>';
			}
		} else{
			echo '						<tr>
											<td colspan="4">Vous n\'avez pas encore déverouiller de succes</td>
										</tr>';
		}
		echo	'					</table>
								</div>
							</fieldset>
							<fieldset id="fieldset-prof">
								<legend>Quiz posté</legend>';
		$selete_mes_quiz_user = $db->query("SELECT * FROM quiz WHERE id_quiz_user = 1 AND id_user = ".$_SESSION['id'])->fetchAll();
		foreach($selete_mes_quiz_user as $selete_le_quiz_user){
			$slect_nbr_like_quiz = $db->query("SELECT count(*) nbr_like FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_dis_quiz = $db->query("SELECT count(*) nbr_dis FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz'])->fetchArray();
			$slect_nbr_like_quiz_user = $db->query("SELECT count(*) nbr_like_ip FROM quiz_like_quiz WHERE likeOrDislike = 1 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			$slect_nbr_dis_quiz_user = $db->query("SELECT count(*) nbr_dis_ip FROM quiz_like_quiz WHERE likeOrDislike = 0 AND quiz_like_quiz.id_quiz = ".$selete_le_quiz_user['id_quiz']." AND '".$_SERVER['REMOTE_ADDR']."' = ip")->fetchArray();
			if($selete_le_quiz_user['quizComplet'] == 1) {
                echo '<div id="search-div">
					<a href="makeQuiz.php?id_quiz=' . $selete_le_quiz_user['id_quiz'] . '">
						<img id="search-img-pre" src="/quiz' . $selete_le_quiz_user['src'] . '">
						<div id="search-div-img">
							<h2 id="search-h2">' . $selete_le_quiz_user['nom_quiz'] . '</h2>
							<span class="span_id_user_par">Fait par ' . $_SESSION['login'] . '</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>
					<table id="table_mes_quiz_quiz_user">
					    <tr>
                            <td id="mes_quiz_quiz_user_like_td">
            ' . $slect_nbr_like_quiz['nbr_like'] . '
        <a href="likedislike_user.php?l=1&q=' . $selete_le_quiz_user['id_quiz'] . '">
						            <svg ';
                if ($slect_nbr_like_quiz_user['nbr_like_ip'] > 0) {
                    echo 'style="fill: blue;"';
                }
                echo ' class="index-svg-like_bis" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"></path></g></svg>
					            </a>
                            </td>
                            <td>
                                <a href="deleteQuiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                                    <img class="poubelleIdImg" src="commun/trash.png" alt="poubelle ">
                                </a>
                                <a href="poster_quiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                                    <img class="crayonIdImg" src="commun/crayon.png" alt="crayon ">
                                </a>
                            </td>
                        </tr>
					    <tr>
                            <td>
        ' . $slect_nbr_dis_quiz['nbr_dis'] . '
        <a href="likedislike_user.php?l=0&q=' . $selete_le_quiz_user['id_quiz'] . '">
                                    <svg ';
                if ($slect_nbr_dis_quiz_user['nbr_dis_ip'] > 0) {
                    echo 'style="fill: red;"';
                }
                echo ' class="index-svg-like_bis" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"></path></g></svg>
					            </a>
                            </td>
                            <td>
                            <span onclick="copy('.$selete_le_quiz_user['id_quiz'].');">
                                <img class="shareIdImg" src="commun/share.png" alt="partager">
                            </span>
                            </td>
                        </tr>
                    </table>
				</div><br>';
            }elseif($selete_le_quiz_user['quizComplet'] == 0){

                $lienFinirQuiz = boutonFinirQuiz($selete_le_quiz_user['id_quiz'], $selete_le_quiz_user, $db);
                echo '<div id="search-div">
                        <a href="' .$lienFinirQuiz.'">
                            <img id="search-img-pre" src="/quiz' . $selete_le_quiz_user['src'] . '">
                            <div id="search-div-img">
                                <h2 id="search-h2">' . $selete_le_quiz_user['nom_quiz'] . '</h2>
                                <span class="span_id_user_par">Fait par ' . $_SESSION['login'] . '</span>
                                 <span class="span_id_user_par">Cliquez ici pour poster votre quiz</span>
                            </div>
                        </a>
                        <a href="deleteQuiz.php?q='.$selete_le_quiz_user['id_quiz'].'">
                            <img class="poubelleIdImg" src="commun/trash.png" alt="poubelle ">
                        </a>
				       </div>';
            }
		}
		if(count($selete_mes_quiz_user) == 0){
			echo 'Vous n\'avez pas publié de quiz<br>
			<a href="poster_quiz.php">Poster en un</a>';
		}
		echo '	            </fieldset>
							<div id="div-form">
								<h2 id="h2-form">Modifier profil</h2>
								<form action="changer-mdp_prof.php" method="post" class="form">
									<h2>Changer de mot de pass</h2>
									<label class="label-all" for="pass">Mot de passe : </label>
									<input class="input-all" type="password" name="pass" required>
									<img class="show-password" id="monImage" src="commun/oeil_cache.png"/>
									<label class="label-all" for="pass_confirm">Confirmation du mot de passe : </label>
									<input class="input-all" type="password" name="pass_confirm" required>
									<img class="show-password2" id="monImage2" src="commun/oeil_cache.png"/>
									<br><br>
									<div class="button">
										<input id="input-comfirm-chag-pass" class="input-all" type="submit" value="Confirmer" class="id-bt">
									</div>
								</form>
								<form action="supr-compte_prof.php" method="post" class="form">
									<h2 id="h2-form-supr-compt">Supprimer votre compte<br>Attention cette action est irréversible</h2>
									<label class="label-all" for="pass_supr">Mot de passe : </label>
									<input class="input-all" type="password" name="pass_supr" required>
									<img class="show-password3" id="monImage3" src="commun/oeil_cache.png"/>
									<div class="button">
										<input id="input-comfirm-supr-compt" class="input-all" type="submit" value="Supprimer" class="id-bt">
									</div>
								</form>
							</div>
							<br>
				 		    <form id="form-lange" class="form">
								<h2>Changer la langue</h2>
								<select id="lang" onchange="lang_change();" name="langue-select">
									<option value="fr">Français</option>
									<option value="en">Anglais</option>
									<option value="de">Allemand</option>
									<option value="es">espagnol</option>
									<option value="zh-CN">Chinois</option>
								</select>
							</form>	
                            <input id="clipbord_temp" type="text">
						</div>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
						<script type="text/javascript">
							$(document).ready(function(){
								$(\'.show-password\').click(function() {
									if($(this).prev(\'input\').prop(\'type\') == \'password\') {
										//Si c\'est un input type password
										$(this).prev(\'input\').prop(\'type\',\'text\');
										$(\'#monImage\').attr(\'src\',\'commun/oeil.png\');
									} else {
										//Sinon
										$(this).prev(\'input\').prop(\'type\',\'password\');
										$(\'#monImage\').attr(\'src\',\'commun/oeil_cache.png\');
									}
								});
							});
						</script>
						<script type="text/javascript">
							$(document).ready(function(){
								$(\'.show-password2\').click(function() {
									if($(this).prev(\'input\').prop(\'type\') == \'password\') {
										//Si c\'est un input type password
										$(this).prev(\'input\').prop(\'type\',\'text\');
										$(\'#monImage2\').attr(\'src\',\'commun/oeil.png\');
									} else {
										//Sinon
										$(this).prev(\'input\').prop(\'type\',\'password\');
										$(\'#monImage2\').attr(\'src\',\'commun/oeil_cache.png\');
									}
								});
							});
						</script>
						<script type="text/javascript">
							$(document).ready(function(){
								$(\'.show-password3\').click(function() {
									if($(this).prev(\'input\').prop(\'type\') == \'password\') {
										//Si c\'est un input type password
										$(this).prev(\'input\').prop(\'type\',\'text\');
										$(\'#monImage3\').attr(\'src\',\'commun/oeil.png\');
									} else {
										//Sinon
										$(this).prev(\'input\').prop(\'type\',\'password\');
										$(\'#monImage3\').attr(\'src\',\'commun/oeil_cache.png\');
									}
								});
							});
						</script>
						<script type="text/javascript">
							let togg1 = document.getElementById("togg1");
							let togg2 = document.getElementById("togg2");
							let d1 = document.getElementById("d2");
							let d2 = document.getElementById("d2");
							togg1.addEventListener("click", () => {
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
                            function copy(txt){
                                var text = document.querySelector("#clipbord_temp");
                                new_value = "'; echo $domaine.'"+"quiz/makeQuiz.php?id_quiz="+txt;
                                text.value = new_value;
                                text.select()
                                document.execCommand(\'copy\');
                                alert("Lien copié : "+new_value+"\nIdentifiant du quiz : "+txt);
                            }
						</script>
						
					</body>
				</html>';
	} elseif(isset($_GET['u'])) {
        $xp = 0;
        $level = 1;
        $select_quiz_effectué = $db->query("SELECT * FROM quiz_statistique, quiz, quiz_image WHERE quiz.id_image_quiz = quiz_image.id_image AND quiz.id_quiz_user = 0 AND quiz_statistique.id_user = ".$_GET['u']." and quiz_statistique.id_quiz = quiz.id_quiz ORDER BY `quiz_statistique`.`favoris` DESC")->fetchAll();
        $selct_quiz_pour_xp = $db->query("SELECT quiz.xp, quiz_statistique.id_user, quiz_statistique.id_quiz FROM quiz_statistique, quiz WHERE quiz_statistique.id_user = ".$_GET['u']." and quiz.id_quiz = quiz_statistique.id_quiz")->fetchAll();
        $selct_succes_pour_xp = $db->query("SELECT * FROM quiz_membre_succes, quiz_succes WHERE quiz_membre_succes.id_membre = ".$_GET['u']." and quiz_membre_succes.id_succes = quiz_succes.id_succes")->fetchAll();
        $selct_le_membre_connecté = $db->query("SELECT * FROM `quiz_membre` WHERE id = ".$_GET['u'])->fetchArray();
        if (count($selct_quiz_pour_xp) > 0) {
            foreach($selct_quiz_pour_xp as $row2) {
                $xp =  $xp + $row2['xp'];
            }
        }
        if (count($selct_succes_pour_xp) > 0) {
            foreach($selct_succes_pour_xp as $row2) {
                $xp =  $xp + $row2['xp_succes'];
            }
        }
        $level = intdiv($xp,15)+1;
        $xpbis = $xp-(($level-1)*15) ;
        $selct_les_sucsses_du_membre = $db->query("SELECT quiz_succes.nom_succes, quiz_succes.xp_succes, quiz_succes.descri_succes, quiz_membre_succes.id_succes, quiz_membre_succes.date_succes FROM quiz_succes, quiz_membre_succes WHERE ".$_GET['u']." = quiz_membre_succes.id_membre AND quiz_membre_succes.id_succes = quiz_succes.id_succes")->fetchAll();
        echo	'<!DOCTYPE html>
				<html>
					<head>';
        $css = array("profil.css", "commun/bandeau.css", "css.css");
        afficher_head("Profil", $css, "UTF-8");
        echo'			<script src="commun/image-picker/image-picker.js" type="text/javascript"></script>
					</head>
					<body>';
        include ("bandeau.php");
        echo'			<a id="lien-paypal" href="https://paypal.me/MaloMouron" target="_blank">
							<img id="img-paypal" src="commun/don.png" alt="logo don paypal" class="div-a-2">
						</a>';
        echo'			<div id="div1">
							<h1>Vous êtes sur le profil de '.$selct_le_membre_connecté['login'].'</h1>
							<div id="div-pre-h1">';
        if ($selct_le_membre_connecté['image_profil'] == "default"){
            echo				'<button class="button-all button_sans_defaultbis" id="togg1" style="-webkit-appearance: none;text-rendering: auto;color: transparent;letter-spacing: normal;word-spacing: normal;text-transform: none;text-indent: 0px;text-shadow: none;display: inline-block;text-align: center;cursor: pointer;background-color: transparent;box-sizing: initial;margin: 0em;padding: 0px 0px;border-width: 0px;border-style: solid;border-color: transparent;border-image: none;">
									<img class="lienAfficher" src="commun/vide-png.png" alt="image de profil" id="img-prof" style="cursor: pointer; max-width: 260px; min-width: 200px; min-height: 175px; max-height: 230px;">
								</button>';
        } else {
            echo				'<button class="button-all" id="togg1" style="-webkit-appearance: none;text-rendering: auto;color: transparent;letter-spacing: normal;word-spacing: normal;text-transform: none;text-indent: 0px;text-shadow: none;display: inline-block;text-align: center;cursor: pointer;background-color: transparent;box-sizing: initial;margin: 0em;padding: 0px 0px;border-width: 0px;border-style: solid;border-color: transparent;border-image: none;">
									<img src="'.$selct_le_membre_connecté['image_profil'].'" style="cursor: pointer;max-width: 217px;min-width: 200px;">
								</button>
								';
        }
        echo 					'<p>
                                    <b id="b-niveau-descr">'.$selct_le_membre_connecté['login'].'</b>
                                    <br>
                                    <span id="span-niveau-descr">Niveau : 
                                        <span id="span-niveau-descr-int">'.$level.'</span>
                                    </span>
                                    <br>
                                    <span id="span-xp-descr">Expérience : '.$xpbis.'/15</span><br>';

        if (isset($_SESSION['id'])) {
            $selete_abonne = $db->query("SELECT * FROM quiz_subscription_membre WHERE idUser =".$_SESSION['id']." AND idUserAbonnement = ".$selct_le_membre_connecté['id'])->numRows();
            if ($selete_abonne == 0){
                echo '<a class="quiz_utilisateur-a-profil" href="abonnement.php?a='.$selct_le_membre_connecté['id'].'">S\'abonner</a>';
            }else{
                echo '<a class="quiz_utilisateur-a-profil" href="abonnement.php?b=b&a='.$selct_le_membre_connecté['id'].'">Se désabonné<img class="quiz_utilisateur-img-ajt" src="commun/abonner.png"></a>';

            }
        }
        echo'                   </p>
							</div>';
        if (isset($_SESSION['id'])){
            echo'<a id="signaler_profil" href="signal.php?id='.$selct_le_membre_connecté['id'].'"><img id="signaler_profil_img" src="commun/signal.png"></a>';
        }

        echo'                <div id="div-table-bis">
								<table id="table-fav" class="table-all-td">
									<thead class="thead-all">
										<tr>
											<th id="th-colspan" colspan="8"><b>Tableau des quiz<b></th>
										</tr>
									</thead>
									<tbody class="tbody-all">
										<tr>
											<th rowspan="2" colspan="2" class="td-prem-fav" class="td-all"><b>Quiz Effectué : </b></th>
											<th rowspan="2" class="td-prem-fav" class="td-prem-fav-bis" class="td-all"><b>Date : </b></th>
											<td id="info_tbl_quiz" colspan="5" class="td-prem-fav" class="td-prem-fav-bis" class="td-all"><b>Info : </b></td>
										</tr>
										<tr>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de question : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de vue : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>XP : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de like : </b></td>
											<td class="td-prem-fav_info" class="td-prem-fav-bis" class="td-all"><b>Nombre de dislike : </b></td>
										</tr>
									</tbody>
									<tfoot>';
        if (count($select_quiz_effectué) > 0) {
            foreach($select_quiz_effectué as $row1) {
                $select_nombre_de_question_pour_les_quiz_effectué = $db->query("SELECT COUNT(*) nombre_question FROM quiz_question where id_quiz = ".$row1['id_quiz'])->fetchArray();
                $select_nombre_de_like_pour_les_quiz_effectué = $db->query("SELECT *  FROM quiz_like_quiz where likeOrDislike = 1 AND id_quiz = ".$row1['id_quiz'])->numRows();
                $select_nombre_de_dislike_pour_les_quiz_effectué = $db->query("SELECT *  FROM quiz_like_quiz where likeOrDislike = 0 AND id_quiz = ".$row1['id_quiz'])->numRows();
                echo '					<tr>
                                            <td class="td-all" id="td-all-css-id">'.$row1['nom_quiz'].'</td>
											<td class="td-all" id="td-deusi-fav-1"><img id="img_profil_quiz" src="'.$row1['src'].'" alt="img presentation quiz"></td>
                                            <td class="td-all" class="td-all-css">'.$row1['date'].'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_question_pour_les_quiz_effectué['nombre_question'].'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$row1['vue'].' vues</td>
                                            <td class="td-all" id="td-nbr-quest">+'.$row1['xp'].'xp</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_like_pour_les_quiz_effectué.'</td>
                                            <td class="td-all" id="td-nbr-quest">'.$select_nombre_de_dislike_pour_les_quiz_effectué.'</td>
                                        </tr>';
            }
        }else{
            echo '<tr>
					<td id="td-deusi-fav-2" class="td-all" colspan="8">
						Aucun quiz effectué par cette utilisateur
					</td>
				</tr>';
        }

        echo	'					</tfoot>
								</table>
							</div>
							<fieldset id="fieldset-prof">
								<legend>Succès</legend>
								<div>
									<table id="table-sucss">
										<tr id="first_tr_succses">
											<td class="td-sucss-ex" class="td-sucss">Nom du succès</td>
											<td class="td-sucss-ex" class="td-sucss">Description du succès</td>
											<td class="td-sucss-ex" class="td-sucss">Xp reporté</td>
											<td class="td-sucss-ex" class="td-sucss">Date</td>
										</tr>';
        if (count($selct_les_sucsses_du_membre) > 0) {
            foreach ($selct_les_sucsses_du_membre as $row_succ) {
                echo 				'	<tr>
											<td class="td-sucss">'.$row_succ['nom_succes'].'</td>
											<td class="td-sucss">'.$row_succ['descri_succes'].'</td>
											<td class="td-sucss">'.$row_succ['xp_succes'].'</td>
											<td class="td-sucss">'.$row_succ['date_succes'].'</td>
										</tr>';
            }
        } else{
            echo '						<tr>
											<td colspan="4">Cette utilisateur n\'a pas encore déverouiller de succes</td>
										</tr>';
        }
        echo	'					</table>
								</div>
							</fieldset>
							<fieldset id="fieldset-prof_bis">
								<legend>Quiz posté</legend>';
        $selete_mes_quiz_user = $db->query("SELECT * FROM quiz, quiz_membre WHERE quiz_membre.id = quiz.id_user AND id_quiz_user = 1 AND id_user = ".$_GET['u'])->fetchAll();
        foreach($selete_mes_quiz_user as $selete_le_quiz_user){
            if($selete_le_quiz_user['quizComplet'] == 1) {
                echo '<div id="search-div">
					<a href="makeQuiz.php?id_quiz=' . $selete_le_quiz_user['id_quiz'] . '">
						<img id="search-img-pre" src="/quiz' . $selete_le_quiz_user['src'] . '">
						<div id="search-div-img">
							<h2 id="search-h2">' . $selete_le_quiz_user['nom_quiz'] . '</h2>
							<span class="span_id_user_par">Fait par ' . $selete_le_quiz_user['login'] . '</span>
						</div>
					</a>
					<b id="search-b1">+5 xp</b>
				</div><br>';
            }
        }
        if(count($selete_mes_quiz_user) == 0){
            echo 'Cette utilisateur n\'a pas publié de quiz';
        }
        echo '	            </fieldset><br><br>
						</div>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
						<script type="text/javascript">
                            function copy(txt){
                                var text = document.querySelector("#clipbord_temp");
                                new_value = "'; echo $domaine.'"+"quiz/makeQuiz.php?id_quiz="+txt;
                                text.value = new_value;
                                text.select()
                                document.execCommand(\'copy\');
                                alert("Lien copié : "+new_value+"\nIdentifiant du quiz : "+txt);
                            }
						</script>
					</body>
				</html>';
    }elseif(!isset($_SESSION['login']) and !isset($_GET['u'])) {
		echo	'<!DOCTYPE html>
				<html>
					<head>';
		$css = array("css.css", "profil.css", "commun/bandeau.css");
		afficher_head("Profil", $css, "UTF-8");
		echo'		</head>
					<body>';
		include ("bandeau.php");
		echo'			<div id="div1">
							<h1 id="h1-deux-else">Vous n\'êtes pas connecté</h1>
						</div>
					</body>
				</html>';
	}
	include ('footer.php');
?>