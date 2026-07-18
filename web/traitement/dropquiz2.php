<?php
include("function.php");

if (isset($_POST['id'])) {
    try {
        $quiz_id = $_POST['id'];
        $values = array($quiz_id);

        // 1. D'abord supprimer les fichiers audio associés
        $query_audio = "DELETE FROM quiz_audio WHERE quiz2_id = ?";
        PDO($query_audio, $values);

        // 2. Supprimer les résultats des quiz
        $query_resultats = "DELETE FROM quiz_resultat2 WHERE quiz2_id = ?";
        PDO($query_resultats, $values);

        // 3. Supprimer les questions
        $query_questions = "DELETE FROM qst_quiz_2 WHERE quiz2_id = ?";
        PDO($query_questions, $values);

        // 4. Enfin supprimer le quiz lui-même
        $query_quiz = "DELETE FROM quiz2 WHERE quiz2_id = ?";
        PDO($query_quiz, $values);

        // Redirection en cas de succès
        header("Location: ../quiz_espace_teacher.php?etat=true");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, enregistrer l'erreur et rediriger
        header("Location: ../quiz_espace_teacher.php?etat=false");
        exit();
    }
} else {
    // Si aucun ID n'est fourni
    header("Location: ../quiz_espace_teacher.php?etat=false");
    exit();
}
?>