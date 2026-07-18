mai<?php
session_start();
include("function.php");

if (!isset($_POST['id']) || !isset($_SESSION['teacher_id'])) {
    header("Location: ../quiz_espace_teacher.php");
    exit();
}

$quiz_id = $_POST['id'];
$teacher_id = $_SESSION['teacher_id'];

// Vérifier que le quiz appartient bien à l'enseignant
$check_query = "SELECT quiz3_id FROM quiz3 WHERE quiz3_id = ? AND teacher_id = ?";
$check_result = PDO($check_query, array($quiz_id, $teacher_id));

if ($check_result->rowCount() > 0) {
    // Supprimer d'abord les questions associées
    $delete_questions = "DELETE FROM qst_quiz_3 WHERE quiz3_id = ?";
    PDO($delete_questions, array($quiz_id));

    // Supprimer les résultats associés
    $delete_results = "DELETE FROM quiz_resultat3 WHERE quiz3_id = ?";
    PDO($delete_results, array($quiz_id));

    // Supprimer le quiz
    $delete_quiz = "DELETE FROM quiz3 WHERE quiz3_id = ?";
    PDO($delete_quiz, array($quiz_id));

    header("Location: ../quiz_espace_teacher.php?etat=true");
} else {
    header("Location: ../quiz_espace_teacher.php?etat=false");
}
exit();
?> 