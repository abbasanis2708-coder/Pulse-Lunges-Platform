<?php

session_start();

include("function.php");

if (!isset($_POST['qst'])) {
  // La variable 'qst' n'est pas définie, vous pouvez gérer ce cas selon vos besoins
}

// Récupérer l'ID du dernier quiz2
$query1 = "SELECT quiz2_id FROM quiz2 ORDER BY quiz2_id DESC LIMIT 1";
$value1 = array();
$stm1 = PDO($query1, $value1);

if ($stm1 === false) {
  // S'il y a une erreur lors de l'exécution de la requête
  $id_quiz = 1;
} else {
  $row1 = $stm1->fetch(PDO::FETCH_ASSOC);
  if (!$row1) {
    // Si la requête ne renvoie aucun résultat
    $id_quiz = 1;
  } else {
    $id_quiz = $row1['quiz2_id'] + 1;
  }
}


for ($i = 1; $i <= $_POST['qst']; $i++) {
    // Récupérer le dernier ID de question de la table qst_quiz_2
$query2 = "SELECT qst_id FROM qst_quiz_2 ORDER BY qst_id DESC LIMIT 1";
$value2 = array();
$stm2 = PDO($query2, $value2);

if ($stm2 === false) {
  // S'il y a une erreur lors de l'exécution de la requête
  $last_qst_id = 0;
} else {
  $row2 = $stm2->fetch(PDO::FETCH_ASSOC);
  if (!$row2) {
    // Si la requête ne renvoie aucun résultat
    $last_qst_id = 0;
  } else {
    $last_qst_id = $row2['qst_id'];
  }
}

  if (isset($_POST['titre']) && isset($_POST['question' . $i]) && isset($_POST['option_1' . $i]) && isset($_POST['option_2' . $i])
    && isset($_POST['option_3' . $i]) && isset($_POST['option_4' . $i]) && isset($_POST['cas_clinique' . $i]) 
    && isset($_POST['age' . $i]) && isset($_POST['sexe' . $i]) && isset($_POST['condition_physique' . $i]) && isset($_POST['examen' . $i])
    && isset($_POST['diagnostics_passes_et_actuels' . $i]) && isset($_POST['poids' . $i]) && isset($_POST['masse_corporelle' . $i])
    && isset($_POST['frequence_cardiaque' . $i]) && isset($_POST['fonction_cardiaque' . $i]) && isset($_POST['lieu_auscultation_cardiaque' . $i])
    && isset($_POST['antecedents_medicaux_familiaux' . $i]) && isset($_POST['option_correct' . $i])) {

    if (empty($_POST['titre']) || empty($_POST['question' . $i]) || empty($_POST['option_1' . $i]) || empty($_POST['option_2' . $i])
      || empty($_POST['option_3' . $i]) || empty($_POST['option_4' . $i]) || empty($_POST['cas_clinique' . $i]) 
      || empty($_POST['age' . $i]) || empty($_POST['sexe' . $i]) || empty($_POST['condition_physique' . $i]) || empty($_POST['examen' . $i])
      || empty($_POST['diagnostics_passes_et_actuels' . $i]) || empty($_POST['poids' . $i]) || empty($_POST['masse_corporelle' . $i])
      || empty($_POST['frequence_cardiaque' . $i]) || empty($_POST['fonction_cardiaque' . $i]) || empty($_POST['lieu_auscultation_cardiaque' . $i])
      || empty($_POST['antecedents_medicaux_familiaux' . $i]) || empty($_POST['option_correct' . $i])) {

      echo "Remplissez tous les champs !";

    } else {
      
    // // Insérer le quiz2
      $query3 = "INSERT INTO quiz2 (quiz2_id, nom_quiz, teacher_id) VALUES (?, ?, ?)";
      $values3 = array($id_quiz, test_input($_POST['titre']), $_SESSION['teacher_id']);
      $result3 = PDO($query3, $values3);
    



      
      
      $query9 = "INSERT INTO qst_quiz_2(quiz2_id,
                                            n_question,
                                            question_text,
                                            option_1,
                                            option_2,
                                            option_3,
                                            option_4,
                                            cas_clinique,
                                            age,
                                            sexe,
                                            condition_physique,
                                            examen,
                                            diagnostics_passes_et_actuels,
                                            poids,
                                            masse_corporelle,
                                            frequence_cardiaque,
                                            fonction_cardiaque,
                                            lieu_l_auscultation_cardiaque,
                                            antecedents_medicaux_familiaux,
                                            option_correct)
             values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

      $values9 = array($id_quiz,$i,test_input($_POST['question'.$i]),test_input($_POST['option_1'.$i]),
        				test_input($_POST['option_2'.$i]),test_input($_POST['option_3'.$i]),test_input($_POST['option_4'.$i])
                        ,test_input($_POST['cas_clinique'.$i]),test_input($_POST['age'.$i]),test_input($_POST['sexe'.$i])
                    ,test_input($_POST['condition_physique'.$i]),test_input($_POST['examen'.$i]),test_input($_POST['diagnostics_passes_et_actuels'.$i])
                ,test_input($_POST['poids'.$i]),test_input($_POST['masse_corporelle'.$i]),test_input($_POST['frequence_cardiaque'.$i]),test_input($_POST['fonction_cardiaque'.$i])
            ,test_input($_POST['lieu_auscultation_cardiaque'.$i]),test_input($_POST['antecedents_medicaux_familiaux'.$i]),test_input($_POST['option_correct'.$i]));

      $result9=PDO($query9,$values9);
      // Récupérer le nombre d'audio à ajouter
      $audioCount = $_POST["audioCount" . $i]-1;
      $qst_id = $last_qst_id + 1;
      // echo "audioCount: " . $audioCount . "<br>";
      // echo "qst_id: " . $qst_id . "<br>";
      
        // Insérer les enregistrements audio dans la table "vocaux"
        for ($j = 1; $j <= $audioCount; $j++) {
          // echo 'Entrée dans la boucle <br>';
          if (isset($_POST['audio_file' . $i . '_' . $j])) {
            // echo 'Vérification de la condition 1 <br>';
            if (empty($_POST['audio_file' . $i . '_' . $j])) {
                echo "Remplissez tous les champs !";
            } 
            else {
              // echo 'Vérification de la condition 2 <br>';
              // Insérer l'enregistrement audio
              $query5 = "INSERT INTO quiz_audio (quiz2_id, qst_id, audio_file) VALUES (?, ?, ?)";
              $values5 = array($id_quiz, $qst_id, test_input($_POST['audio_file' . $i . '_' . $j]));
              $result5 = PDO($query5, $values5);
              // echo 'Itération ' . $j . ' : ' . $_POST['audio_file' . $i . '_' . $j] . '<br>';
              // if ($result5) {
              //   echo 'audio'.$i.'_'.$j.' : saisie <br>';
              // } else {
              //   echo 'audio'.$i.'_'.$j.' : non saisie';
              // }
            }
          } 
          else {
            echo 'Non vérification de la condition 1 <br>';
          }
        }
        
        if ($result5) {
          echo '<script language="Javascript"> document.location.replace("../addquiz2.php?etat=true"); </script>';
        } else {
          echo '<script language="Javascript"> document.location.replace("../addquiz2.php?etat=false1 "); </script>';
        }
      

      
    }
  } else {
    echo '<script language="Javascript"> document.location.replace("../addquiz2.php?etat=false"); </script>';
  }
}
?>
