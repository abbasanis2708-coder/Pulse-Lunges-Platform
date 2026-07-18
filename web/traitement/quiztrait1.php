<?php

      

      include("function.php");

 	?>
<?php

session_start();

// Vérifier si le formulaire de quiz a été soumis
if (isset($_POST['submit'])) {
  // Récupérer l'ID du quiz et les réponses soumises par l'étudiant
  $id_quiz = $_POST['id'];
  $student_id = $_SESSION['student_id'];
  $submitted_answers = $_POST;



  // Compter le nombre de questions dans le quiz
  $query = "SELECT COUNT(quiz1_id) AS nbr FROM qst_quiz_1 WHERE quiz1_id = ?";
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
    $query2 = "SELECT * FROM qst_quiz_1 WHERE quiz1_id = ? AND n_question = ?";
    $values2 = array($id_quiz, $q);
    $res2 = PDO($query2, $values2);
    if ($res2->rowCount() != 0) {
      $row = $res2->fetch();


      // Récupérer la réponse correcte pour la question actuelle
      $correct_answer = $row['option_1'];
      // Vérifier si la réponse soumise par l'étudiant est correcte
      if (isset($submitted_answers[$q]) && $submitted_answers[$q] == $correct_answer) {

        $question_correct++;
      } else {
        $question_incorrect++;
      }
    }
  }
  
  
  

  // Check if the student ID and quiz ID already exist in the table
  $queryCheck = "SELECT * FROM quiz_resultat1 WHERE quiz1_id = ? AND student_id = ?";
  $valuesCheck = array($id_quiz, $student_id);
  $stmCheck = PDO($queryCheck, $valuesCheck);
  
  if ($stmCheck->rowCount() > 0) {
    // Test already taken
    echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=test"); </script>';
  } else {
    // Execute the query
    $queryInsert = "INSERT INTO quiz_resultat1 (quiz1_id, student_id, resultat, question_correct, question_incorrect) VALUES (?, ?, ?, ?, ?)";
    $valuesInsert = array($id_quiz, $student_id, $question_correct, $question_correct, $question_incorrect);
    $resInsert = PDO($queryInsert, $valuesInsert);
  
    if ($resInsert) {
      echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=true"); </script>';
    } else {
      echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=false"); </script>';
    }
  }
  
}

?>
