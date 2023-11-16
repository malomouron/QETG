<?php
    session_start();
    include ('functions.php');
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    if (isset($_SESSION['id'])){
        $select_verif_signal = $db->query("SELECT * FROM quiz_signalement WHERE id_user_origine = ".$_SESSION['id']." AND id_user_cible = ".$_GET['id'])->numRows();
        if ($select_verif_signal == 0 AND $_SESSION['id'] != $_GET['id']){
            $insert_signal = $db->query("INSERT INTO `quiz_signalement` (`id_user_origine`, `id_user_cible`) VALUES (".$_SESSION['id'].", ".$_GET['id'].")");
        }
        header('Location: profil.php?u='.$_GET['id']);
    }else {
        header('Location: identifier.php');
    }
?>