<?php
	$select_comm = $db->query("SELECT * FROM quiz_commentaire")->fetchAll();
	if (count($select_comm) > 0) {
	    $comt_comm=0;
		foreach($select_comm as $row) {
		    $seect_rep_comm = $db->query("SELECT * FROM quiz_reponse_commentaire, quiz_membre WHERE quiz_membre.id = quiz_reponse_commentaire.id_user AND quiz_reponse_commentaire.id_commentaire = ".$row['id'])->fetchAll();
		    $seect_rep_comm_nbr = $db->query("SELECT * FROM quiz_reponse_commentaire, quiz_membre WHERE quiz_membre.id = quiz_reponse_commentaire.id_user AND quiz_reponse_commentaire.id_commentaire = ".$row['id'])->numRows();
			echo    "<div id=\"commentaire\">
                        <div class=\"inter-com\" id=\"nom-prenom\">
                            <span class=\"class-span\"> Nom : </span>
                            ". $row["nom"]. "<br>
                            <span class=\"class-span\"> Prénom : </span>
                            ". $row["prenom"]. "
                        </div>
                        <div class=\"inter-com\" id=\"email\">
                            <span class=\"class-span\"> Email : </span>
                            ". $row["mail"]. "
                        </div>
                        <div class=\"inter-com\" id=\"commentaire-css\">
                            <span class=\"class-span\"> Commentaire : </span>
                            ".$row["commentaire"]. "
                        </div>
                        <div class=\"inter-com\" id=\"date_create\">
                            <span class=\"class-span\"> Date : </span>
                            ". $row["date_creation"]. "
                        </div>
                        <div class='inter-com'>
                            <span onclick='affich_rep_comm(".$comt_comm.");'><b>Réponse : </b><img id='img_reponse_comm_".$comt_comm."'' class='img_reponse_comm' src='commun/rep_comm.png'></span><br><br>
                            <div style='display: none' class='lise_rep_comm' id='reponse_comm_".$comt_comm."'>";
            if($seect_rep_comm_nbr >0){
                echo '<form action="reponse_commentaire.php" method="post" >
                                    <label>Répondre : </label><input type="text" name="reponse_comm">
                                    <input type="hidden" value="'.$row['id'].'" name="id_comm">
                                </form><br>';
                foreach ($seect_rep_comm as $reponse_comm){
                        echo '<span>'.$reponse_comm['login'].' : '.$reponse_comm['reponse_val'].'</span><br><br>';
                }
            }else{
                echo '  <form action="reponse_commentaire.php" method="post" >
                            <label>Répondre : </label><input type="text" name="reponse_comm">
                            <input type="hidden" value="'.$row['id'].'" name="id_comm">
                        </form><br>
                        <span>Pas de réponse</span><br><br>';
            }
            echo            "</div>
                        </div>
                    </div>";
            $comt_comm++;
		}
	} else {
		echo "pas de commentaire";
	}
	include ('footer.php');
?>