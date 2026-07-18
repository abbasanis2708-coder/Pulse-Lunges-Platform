<?php
include("function.php");

session_start();

// Vérifier si le formulaire de quiz a été soumis
if (isset($_POST['submit'])) {
    // Récupérer l'ID du quiz et les réponses soumises par l'étudiant
    $id_quiz = $_POST['id'];
    $student_id = $_SESSION['student_id'];
    $submitted_answers = $_POST;

    // Compter le nombre de questions dans le quiz
    $query = "SELECT COUNT(quiz2_id) AS nbr FROM qst_quiz_2 WHERE quiz2_id = ?";
    $values = array($id_quiz);
    $stm = PDO($query, $values);
    $nbr_questions = 0;
    if ($stm->rowCount() != 0) {
        while ($row = $stm->fetch()) {
            $nbr_questions = $row['nbr'];
        }
    }

    // Initialiser les variables pour le résultat
    $question_correct = 1;
    $question_incorrect = 1;

    // Parcourir les réponses soumises et vérifier si elles sont correctes
    for ($q = 1; $q <= $nbr_questions; $q++) {
        $query = "SELECT * FROM qst_quiz_2 WHERE quiz2_id = ? AND n_question = ?";
        $values = array($id_quiz, $q);
        $res = PDO($query, $values);
        if ($res->rowCount() != 0) {
            $row = $res->fetch();

            // Récupérer le nombre d'options correctes pour la question actuelle
            $num_correct_options = $row['option_correct'];

            // Construire un tableau avec les options correctes
            $correct_options = array();
            for ($i = 1; $i <= $num_correct_options; $i++) {
                $option_name = "option_" . $i;
                $correct_options[] = $row[$option_name];
            }
            
            // Vérifier si les options soumises par l'étudiant sont correctes
            $submitted_options = array();
            if (isset($submitted_answers[$q])) {
                
                if (is_array($submitted_answers[$q])) {
                    $submitted_options = $submitted_answers[$q];
                } else {
                    $submitted_options[] = $submitted_answers[$q];
                }
            }
            
            // Vérifier si les options soumises sont correctes
            
            foreach ($submitted_options as $option) {
                if (!in_array($option, $correct_options)) {
                    $question_incorrect++;
                }else{
                    $question_correct++;
                }
            }

            
        }
    }

    // Enregistrer les résultats dans la table quiz_resultat2
    $query = "SELECT COUNT(*) AS count FROM quiz_resultat2 WHERE quiz2_id = ? AND student_id = ?";
    $values = array($id_quiz, $student_id);
    $res = PDO($query, $values);
    if ($res->rowCount() != 0) {
        $row = $res->fetch();
        if ($row['count'] == 0) {
            $query = "INSERT INTO quiz_resultat2 (quiz2_id, student_id, resultat, question_correct, question_incorrect) VALUES (?, ?, ?, ?, ?)";
            $values = array($id_quiz, $student_id, $question_correct, $question_correct, $question_incorrect);
            $res = PDO($query, $values);

            if ($res) {
                echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=true"); </script>';
            } else {
                echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=false"); </script>';
            }
    } else {
        echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=test"); </script>';
    }
}


    if ($res) {
        echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=true"); </script>';
    } else {
        echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=false"); </script>';
    }
} else {
    // Rediriger si le formulaire n'a pas été soumis
    header("Location: ../quiz_espace_student.php");
}
?>
