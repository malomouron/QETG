<?php
    session_start();
    include ('functions.php');
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    if (isset($_SESSION['id'])){
        $insert_reponse_comm = $db->query("INSERT INTO `quiz_reponse_commentaire` (`id_commentaire`, `id_user`, `reponse_val`, `ip_rep`) VALUES (".$_POST['id_comm'].", ".$_SESSION['id'].", '".securisation($_POST['reponse_comm'])."', '".$_SERVER['REMOTE_ADDR']."');");
        header('Location: index.php');
    }else {
        header('Location: identifier.php');
    }
    include ('footer.php');


?>