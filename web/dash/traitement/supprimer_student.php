<?php
try {
    // 1. Supprimer d'abord les résultats des quiz de niveau 1
    $query_quiz1 = "DELETE FROM quiz_resultat1 WHERE student_id = ?";
    PDO($query_quiz1, array($id));

    // 2. Supprimer les résultats des quiz de niveau 2
    $query_quiz2 = "DELETE FROM quiz_resultat2 WHERE student_id = ?";
    PDO($query_quiz2, array($id));

    // 3. Supprimer les résultats des quiz de niveau 3
    $query_quiz3 = "DELETE FROM quiz_resultat3 WHERE student_id = ?";
    PDO($query_quiz3, array($id));

    // 4. Enfin, supprimer l'étudiant
    $query_student = "DELETE FROM student WHERE student_id = ?";
    PDO($query_student, array($id));

    if($tab[count($tab)-1]=="student.php") {
        echo '<script language="Javascript"> document.location.replace("student.php?etat=true"); </script>';
    }
} catch (PDOException $e) {
    error_log("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
    if($tab[count($tab)-1]=="student.php") {
        echo '<script language="Javascript"> document.location.replace("student.php?etat=false"); </script>';
    }
}
?>