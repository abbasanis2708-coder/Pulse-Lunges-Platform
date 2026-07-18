<?php
include("function.php");

if (isset($_POST['id'])) {
    try {
        $quiz_id = $_POST['id'];
        $values = array($quiz_id);

        // 1. D'abord supprimer les résultats des quiz
        $query_resultats = "DELETE FROM quiz_resultat1 WHERE quiz1_id = ?";
        PDO($query_resultats, $values);

        // 2. Ensuite supprimer les questions
        $query_questions = "DELETE FROM qst_quiz_1 WHERE quiz1_id = ?";
        PDO($query_questions, $values);

        // 3. Enfin supprimer le quiz lui-même
        $query_quiz = "DELETE FROM quiz1 WHERE quiz1_id = ?";
        PDO($query_quiz, $values);

        // Redirection en cas de succès
        echo '<script>
            document.location.replace("../quiz_espace_teacher.php?etat=true");
        </script>';
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message et rediriger
        error_log("Erreur lors de la suppression du quiz : " . $e->getMessage());
        echo '<script>
            document.location.replace("../quiz_espace_teacher.php?etat=false");
        </script>';
    }
} else {
    // Si aucun ID n'est fourni
    echo '<script>
        document.location.replace("../quiz_espace_teacher.php?etat=false");
    </script>';
}
?>