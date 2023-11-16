<?php
    session_start();
    include ('functions.php');
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    if(isset($_SESSION['id'])){
        $selectQuizDelete = $db->query("select * from quiz where id_quiz = ".$_REQUEST['q'])->fetchArray();
        if(count($selectQuizDelete) > 0 AND $selectQuizDelete['id_user'] == $_SESSION['id']){
            $deleteQuiz = $db->query("DELETE FROM quiz WHERE quiz.id_quiz = ".$_REQUEST['q']);
        }
    }else{
        include ('footer.php');
        header('Location : identifier.php');
    }
    include ('footer.php');
    header('Location: quiz_utilisateur.php?defaultOnglet3');
?>