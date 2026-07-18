<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Evaluation Espace</title>
  <link rel="stylesheet" href="static/css/bootstrap.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="static/css/index.css">
  <link rel="stylesheet" href="static/css/cours-espace.css">
</head>
<body>

<?php
include("traitement/navbar_student.php");
include("traitement/function.php");
capterConnexion($_SESSION['student_id']);

if (isset($_GET['etat'])) {
  $etatMessages = [
    "true" => ["alert-success", "far fa-check-square", "L'opération s'effectue avec <strong>Succès!</strong>"],
    "false" => ["alert-danger", "fas fa-times", "<strong>Erreur !</strong> lors de l'opération !"],
    "test" => ["alert-warning", "fas fa-exclamation-triangle", "<strong>TEST</strong> déjà effectué."]
  ];
  if (isset($etatMessages[$_GET['etat']])) {
    list($alertClass, $iconClass, $message) = $etatMessages[$_GET['etat']];
    echo "<div class='alert $alertClass'><i class='$iconClass'></i> $message</div>";
  }
}
?>

<main>
<ul class="nav nav-pills nav-fill tab">
  <li class="nav-item">
    <button type="button" style="margin-left: 30%;" class="btn btn-link tablinks" onclick="window.location.href='quiz_espace_student.php?quiz=1'" id="defaultOpen">Quiz niveau 1</button>
  </li>
  <li class="nav-item">
    <button type="button" style="margin-left: 40%;" class="btn btn-link tablinks" onclick="window.location.href='quiz_espace_student.php?quiz=2'">Quiz niveau 2</button>
  </li>
  <li class="nav-item">
    <button type="button" style="margin-left: 30%;" class="btn btn-link tablinks" onclick="window.location.href='quiz_espace_student.php?quiz=3'">Quiz niveau 3</button>
  </li>
</ul>

<section class="Posts">

<?php
function displayQuiz($quizTable, $quizIdField, $quizFormAction, $titreField, $resultTable) {
  global $_SESSION;
  echo "<div class='tabcontent'>";
  
  $query = "SELECT * FROM $quizTable ORDER BY $quizIdField DESC";
  $stm = PDO($query, array());
  
  if ($stm->rowCount() != 0) {
    while ($row = $stm->fetch()) {
      $titre = isset($row[$titreField]) ? test_input($row[$titreField]) : 'Quiz';
      echo "
        <div class='container'>
          <div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12'>
              <div class='card text-center cardpadding'>
                <div class='card-body'>
                  <div class='media'>
                    <img src='static/img/cours espace/undraw_files1_9ool.svg' class='align-self-start mr-3 pdfsize' alt='pdf'>
                    <div class='media-body'> 
                      <h4 class='mt-0'>Quiz : $titre</h4>
                      <form method='post' action='$quizFormAction'>
                        <input type='hidden' name='id' value='".test_input($row[$quizIdField])."'>
                        <button type='submit' class='btn btn-outline-danger btnmarging'>Faire le test</button>
                      </form>

                      <button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#collapse_".$row[$quizIdField]."'
                        aria-expanded='false' aria-controls='collapseExample'>
                        <i class='fas fa-sort-down fa-2x'></i> Voir mes résultats
                      </button>

                      <div class='collapse' id='collapse_".$row[$quizIdField]."'>
                        <div class='card card-body'>
                          <table class='table'>
                            <thead>
                              <tr class='trst'>
                                <th scope='col' class='center'>Résultat</th>
                              </tr>
                            </thead>
                            <tbody>";
                            
      // Récupérer les résultats de l'étudiant pour ce quiz
      $query_result = "SELECT * FROM $resultTable WHERE $quizIdField = ? AND student_id = ?";
      $result = PDO($query_result, array($row[$quizIdField], $_SESSION['student_id']));
      
      if ($result->rowCount() > 0) {
        while ($res = $result->fetch()) {
          if ($resultTable === 'quiz_resultat3') {
            if ($res['diagnostic'] !== null) {
              if ($res['resultat'] !== null) {
                echo "<tr><td>Note : " . htmlspecialchars($res['resultat']) . "/20</td></tr>";
              } else {
                echo "<tr><td>Quiz terminé - En attente de l'évaluation du professeur</td></tr>";
              }
            } else {
              echo "<tr><td>Une note sera bientot attribuée</td></tr>";
            }
          } else {
            $score = $res['resultat'] - 1;
            echo "<tr><td>" . $score . " réponses correctes</td></tr>";
          }
        }
      } else {
        echo "<tr><td>Vous n'avez pas encore fait ce quiz</td></tr>";
      }

      echo "            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>";
    }
  } else {
    echo "<div class='container mt-4'><div class='alert alert-info'>Aucun quiz disponible.</div></div>";
  }
  echo "</div>";
}

$quizSelected = isset($_GET['quiz']) ? intval($_GET['quiz']) : 1;
if ($quizSelected == 1) {
    displayQuiz("quiz1", "quiz1_id", "quiz_student.php", "nom_quiz", "quiz_resultat1");
} elseif ($quizSelected == 2) {
    displayQuiz("quiz2", "quiz2_id", "quiz_student2.php", "nom_quiz", "quiz_resultat2");
} elseif ($quizSelected == 3) {
    displayQuiz("quiz3", "quiz3_id", "quiz_student3.php", "nom_quiz", "quiz_resultat3");
}
?>

</section>
</main>

<?php include("traitement/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
