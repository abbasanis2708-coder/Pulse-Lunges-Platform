<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Noter Quiz Niveau 3</title>
  <link rel="stylesheet" href="static/css/bootstrap.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" >
 
</head>
<body>

<?php
include("traitement/navbar_teacher.php");
include("traitement/function.php");
capterConnexion($_SESSION['teacher_id']);

// Vérifier si l'ID du quiz est fourni
if (!isset($_POST['quiz3_id']) && !isset($_GET['quiz3_id'])) {
    header("Location: quiz_espace_teacher.php?etat=false");
    exit();
}

$quiz3_id = isset($_POST['quiz3_id']) ? $_POST['quiz3_id'] : $_GET['quiz3_id'];

// Récupérer les informations du quiz
$query_quiz = "SELECT * FROM quiz3 WHERE quiz3_id = ? AND teacher_id = ?";
$values_quiz = array($quiz3_id, $_SESSION['teacher_id']);
$stm_quiz = PDO($query_quiz, $values_quiz);

if ($stm_quiz->rowCount() == 0) {
    header("Location: quiz_espace_teacher.php?etat=false");
    exit();
}

$quiz_info = $stm_quiz->fetch();

// Traitement de la notation
if (isset($_POST['save_notes'])) {
    $notes = $_POST['notes'];
    $error_message = "";
    $success_message = "";
    $can_save = true;

    // Vérification stricte de toutes les notes avant de procéder à la sauvegarde
    foreach ($notes as $student_id => $note) {
        if (!empty($note)) {
            if (!is_numeric($note) || $note > 20 || $note < 0) {
                $error_message = "<div class='alert alert-danger'><i class='fas fa-exclamation-triangle'></i> Erreur : Les notes doivent être comprises entre 0 et 20.</div>";
                $can_save = false;
                break;
            }
        }
    }

    // On ne procède à la sauvegarde que si toutes les notes sont valides
    if ($can_save) {
        $success = true;
        foreach ($notes as $student_id => $note) {
            if (!empty($note)) {
                $update_query = "UPDATE quiz_resultat3 SET resultat = ? WHERE quiz3_id = ? AND student_id = ?";
                $update_values = array($note, $quiz3_id, $student_id);
                $update_stm = PDO($update_query, $update_values);
                
                if (!$update_stm) {
                    $success = false;
                    $error_message = "<div class='alert alert-danger'><i class='fas fa-exclamation-triangle'></i> Une erreur est survenue lors de la sauvegarde.</div>";
                    break;
                }
            }
        }

        if ($success) {
            $success_message = "<div class='alert alert-success'><i class='fas fa-check'></i> Les notes ont été sauvegardées avec succès !</div>";
        }
    }
}

// Affichage des messages
if (!empty($error_message)) {
    echo $error_message;
} elseif (!empty($success_message)) {
    echo $success_message;
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-clipboard-check"></i> Noter Quiz : <?php echo test_input($quiz_info['nom_quiz']); ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-users"></i> Étudiants ayant passé le quiz
            </h5>
        </div>
        <div class="card-body">
            <?php
            // Récupérer les étudiants qui ont passé ce quiz
            $query_students = "
                SELECT DISTINCT 
                    s.student_id, 
                    s.name as nom_etudiant, 
                    qr.resultat,
                    qr.date_de_passage,
                    qr.question_posee,
                    qr.theme_revele,
                    qr.diagnostic
                FROM student s
                INNER JOIN quiz_resultat3 qr ON s.student_id = qr.student_id
                WHERE qr.quiz3_id = ?
                ORDER BY s.name ASC
            ";
            $values_students = array($quiz3_id);
            $stm_students = PDO($query_students, $values_students);
            
            if ($stm_students->rowCount() > 0) {
            ?>
                <form method="post" action="note_quiz3.php?quiz3_id=<?php echo $quiz3_id; ?>">
                <input type="hidden" name="quiz3_id" value="<?php echo $quiz3_id; ?>">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-user"></i> Nom de l'étudiant
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-question"></i> Questions posées
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-lightbulb"></i> Thèmes découverts
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-diagnoses"></i> Diagnostic
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-calendar"></i> Date de passage
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-star"></i> Note (/20)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($student = $stm_students->fetch()) {
                                    $date_passage = date('d/m/Y H:i', strtotime($student['date_de_passage']));
                                    
                                    echo "<tr>";
                                    echo "<td><strong>".test_input($student['nom_etudiant'])."</strong></td>";
                                    echo "<td>".nl2br(test_input($student['question_posee']))."</td>";
                                    echo "<td>".test_input($student['theme_revele'])."</td>";
                                    echo "<td>".test_input($student['diagnostic'])."</td>";
                                    echo "<td>".$date_passage."</td>";
                                    echo "<td>
                                            <div class='input-group'>
                                                <input type='number' 
                                                       name='notes[".$student['student_id']."]' 
                                                       value='".$student['resultat']."' 
                                                       class='form-control' 
                                                       min='0' 
                                                       max='20' 
                                                       step='0.5' 
                                                       placeholder='Note'>
                                                <div class='input-group-append'>
                                                    <span class='input-group-text'>/20</span>
                                                </div>
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" name="save_notes" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer les notes
                        </button>
                    </div>
                </form>
            <?php 
            } else {
                echo "<div class='alert alert-info'><i class='fas fa-info-circle'></i> Aucun étudiant n'a encore passé ce quiz.</div>";
            }
            ?>
        </div>
    </div>
</div>

<?php include("traitement/footer.php"); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('input[type="number"]');
    
    // Validation lors de la modification des champs
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (value > 20) {
                this.value = '';
                alert('La note ne peut pas dépasser 20');
            }
            if (value < 0) {
                this.value = '';
                alert('La note ne peut pas être négative');
            }
        });
    });

    // Validation avant l'envoi du formulaire
    form.addEventListener('submit', function(e) {
        let isValid = true;
        inputs.forEach(input => {
            if (input.value !== '') {
                let value = parseFloat(input.value);
                if (value > 20 || value < 0) {
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Les notes doivent être comprises entre 0 et 20');
        }
    });
});
</script>

</body>
</html>
</html>