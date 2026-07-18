<?php

session_start();

include("function.php");



    // Récupérer le dernier ID de cour de la table qst_quiz_2
$query2 = "SELECT cours_id FROM cours ORDER BY cours_id DESC LIMIT 1";
$value2 = array();
$stm2 = PDO($query2, $value2);

if ($stm2 === false) {
  // S'il y a une erreur lors de l'exécution de la requête
  $last_cours_id = 0;
} else {
  $row2 = $stm2->fetch(PDO::FETCH_ASSOC);
  if (!$row2) {
    // Si la requête ne renvoie aucun résultat
    $last_cours_id = 0;
  } else {
    $last_cours_id = $row2['cours_id'];
  }
}

  if (isset($_POST['titre']) && isset($_POST['description' ]) ) {

    if (empty($_POST['titre']) || empty($_POST['description']) ) {

      echo "Remplissez tous les champs !";

    } else {
      
    // // Insérer le quiz2
      $query3 = "INSERT INTO cours (nom_cours, description , teacher_id) VALUES (?, ?, ?)";
      $values3 = array( test_input($_POST['titre']),test_input($_POST['description']), $_SESSION['teacher_id']);
      $result3 = PDO($query3, $values3);
    

      // Récupérer le nombre d'audio à ajouter
      $audioCount = intval($_POST["audioCount"])-1;
      $cours_id=$last_cours_id+1;
      
      if ($audioCount >= 0) {
        // Insérer les enregistrements audio dans la table "vocaux"
        for ($j = 1; $j <= $audioCount; $j++) {
          if (isset($_POST['audio_file_' . $j])) {
            if (empty($_POST['audio_file_'. $j])) {
                echo "Remplissez tous les champs !";
            } 
            else {
              // Insérer l'enregistrement audio
              $query5 = "INSERT INTO cours_audio (cours_id, audio_file) VALUES ( ?, ?)";
              $values5 = array($cours_id, test_input($_POST['audio_file_'. $j]));
              $result5 = PDO($query5, $values5);
            }
          }
        }
      }
      
      // Si l'insertion du cours a réussi, on redirige
      if ($result3) {
        echo '<script language="Javascript"> document.location.replace("../addcour.php?etat=true"); </script>';
      } else {
        echo '<script language="Javascript"> document.location.replace("../addcour.php?etat=false"); </script>';
      }
      

      
    }
  } else {
    echo '<script language="Javascript"> document.location.replace("../addcour.php?etat=false"); </script>';
  }

?>
