<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz Niveau 3 - Cas Clinique</title>
    <link rel="stylesheet" href="static/css/bootstrap.css">
    <link rel="stylesheet" href="static/css/index.css">
    <link rel="stylesheet" href="static/css/cours-espace.css">
</head>
<body>
<?php
include("traitement/navbar_teacher.php");
include("traitement/function.php");
capterConnexion($_SESSION['teacher_id']);

if (!isset($_POST['id'])) {
    echo '<script language="Javascript"> document.location.replace("quiz_espace_teacher.php"); </script>';
} else {
    $id_quiz = $_POST['id'];
}

// Récupérer les informations de base du quiz
$query_quiz = "SELECT * FROM quiz3 WHERE quiz3_id = ? AND teacher_id = ?";
$values_quiz = array($id_quiz, $_SESSION['teacher_id']);
$res_quiz = PDO($query_quiz, $values_quiz);

if ($res_quiz->rowCount() == 0) {
    echo '<div class="alert alert-danger">Quiz non trouvé.</div>';
    exit();
}

$quiz = $res_quiz->fetch();
$description = $quiz['description'] ?? 'Aucune description disponible';
$tentative_max = $quiz['tentative_max'] ?? 5;
$diagnostic_final = $quiz['diagnostic_final'] ?? '';

// Récupérer les thèmes et leurs questions
$query = "SELECT theme, question, reponse_modele FROM qst_quiz_3 WHERE quiz3_id = ? ORDER BY theme";
$values = array($id_quiz);
$res = PDO($query, $values);
$quiz_data = $res->fetchAll();
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Quiz 3 : <?php echo test_input($quiz['nom_quiz']); ?></h3>
                <h3 class="mb-0">
                    <i class="fas fa-redo mr-1"></i>
                    Tentatives max : <?php echo $tentative_max; ?>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <!-- Description -->
            <div class="mb-4">
                <h4>Description du cas</h4>
                <p class="border p-3 bg-light"><?php echo test_input($description); ?></p>
            </div>

            <!-- Thèmes et Questions -->
            <div class="mb-4">
                <h4>Thèmes et Questions</h4>
                <?php foreach ($quiz_data as $theme_data): ?>
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-bookmark mr-2"></i>
                                <?php echo test_input($theme_data['theme']); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php 
                            $questions = json_decode($theme_data['question'], true);
                            $reponses = json_decode($theme_data['reponse_modele'], true);
                            ?>
                            <ul class="list-group">
                                <?php for($i = 0; $i < count($questions); $i++): ?>
                                    <li class="list-group-item">
                                        <div class="font-weight-bold">
                                            <i class="fas fa-question-circle mr-2"></i>
                                            Question : <?php echo test_input($questions[$i]); ?>
                                        </div>
                                        <div class="text-muted text-center mt-2">
                                            <i class="fas fa-comment mr-2"></i>
                                            Réponse attendue : <?php echo test_input($reponses[$i]); ?>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Diagnostic final -->
            <div class="mb-4">
                <h4>Diagnostic final</h4>
                <div class="alert alert-info">
                    <?php echo test_input($diagnostic_final); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("traitement/footer.php"); ?>
</body>
</html>
