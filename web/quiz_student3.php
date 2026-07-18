<?php



session_start();
require_once 'config.php'; // Fichier de configuration pour les constantes
require_once 'traitement/function.php'; // Inclusion de function.php avec le bon chemin



// Définition des réponses neutres
$reponses_neutres = [
    "Je ne saurais pas vous dire.",
    "Je ne suis pas sûr de pouvoir répondre à ça.",
    "Je ne sais pas.",
    "Je ne comprends pas bien votre question.",
    "Je ne suis pas certain de ce que vous voulez dire.",
    "Je ne suis pas sûr de la réponse.",
    "Désolé, je ne sais pas trop."
];

// Vérification de l'authentification
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

// Récupération de l'ID du quiz depuis le POST
if (isset($_POST['id'])) {
    // Si c'est un nouveau quiz, réinitialiser les variables de session
    if (!isset($_SESSION['quiz_id']) || $_SESSION['quiz_id'] !== $_POST['id']) {
        $_SESSION['messages'] = [];
        $_SESSION['nb_questions'] = 0;
        $_SESSION['themes_reveles'] = [];
        // Initialiser le tableau des tentatives si nécessaire
        if (!isset($_SESSION['tentatives_par_quiz'])) {
            $_SESSION['tentatives_par_quiz'] = [];
        }
    }
    $_SESSION['quiz_id'] = $_POST['id'];
    $quiz_id = $_POST['id'];
} else {
    // Si pas d'ID dans le POST, on vérifie la session
    $quiz_id = $_SESSION['quiz_id'] ?? null;
    if ($quiz_id === null) {
        header('Location: quiz_espace_student.php');
        exit();
    }
}

// Initialisation de la session pour les thèmes
if (!isset($_SESSION['themes_reveles'])) {
    $_SESSION['themes_reveles'] = [];
}

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//exception pour les erreurs PDO

    // Vérification que le quiz existe
    $queryCheckQuiz = "SELECT quiz3_id FROM quiz3 WHERE quiz3_id = ?";
    $stmtCheckQuiz = $pdo->prepare($queryCheckQuiz);
    $stmtCheckQuiz->execute([$quiz_id]);
    
    if ($stmtCheckQuiz->rowCount() === 0) {
        $_SESSION['error'] = "❌ Quiz non trouvé.";
        header('Location: quiz_espace_student.php');
        exit();
    }

    // récupération des informations completes
    $queryQuiz = "SELECT quiz3_id, nom_quiz, description, tentative_max 
                  FROM quiz3 
                  WHERE quiz3_id = ?";
    $stmtQuiz = $pdo->prepare($queryQuiz);
    $stmtQuiz->execute([$quiz_id]);
    $quiz_data = $stmtQuiz->fetch();

    if (!$quiz_data) {
        $_SESSION['error'] = "❌ Quiz non trouvé.";
        header('Location: quiz_espace_student.php');
        exit();
    }

    // Si pas de description, on met une valeur par défaut
   if (empty($quiz_data['description'])) {
        $quiz_data['description'] = "Aucune description disponible pour ce quiz.";
    }

    // Si pas de tentative_max, on met une valeur par défaut
    if (empty($quiz_data['tentative_max'])) {
        $quiz_data['tentative_max'] = 5;
    }

    // Récupération et comptage des thèmes pour ce quiz
    $queryThemes = "SELECT DISTINCT theme 
                    FROM qst_quiz_3 
                    WHERE quiz3_id = ? 
                    AND theme IS NOT NULL 
                    AND theme != ''";
    $stmtThemes = $pdo->prepare($queryThemes);
    $stmtThemes->execute([$quiz_id]);
    
    $themes_disponibles = array();
    while ($row = $stmtThemes->fetch()) {

    // Si le thème contient plusieurs valeurs séparées par des virgules
        $theme_array = array_map('trim', explode(',', $row['theme']));
        foreach ($theme_array as $theme) {
            if (!empty($theme) && !in_array($theme, $themes_disponibles)) {
                $themes_disponibles[] = $theme;
            }
        }
    }


    $queryCheck = "SELECT * FROM quiz_resultat3 WHERE quiz3_id = ? AND student_id = ? AND diagnostic IS NOT NULL";
$stmtCheck = $pdo->prepare($queryCheck);
$stmtCheck->execute([$quiz_id, $student_id]);

$test_deja_fait = ($stmtCheck->rowCount() > 0);

// Protection : si le test est déjà fait, on interdit tout envoi (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $test_deja_fait) {
    $_SESSION['error'] = "Opération non autorisée : diagnostic déjà soumis.";
    header("Location: quiz_student3.php?id=" . $quiz_id);
    exit();
}

    if ($stmtCheck->rowCount() > 0) {
        // On ne redirige plus, on stocke juste le message
        $_SESSION['quiz_deja_fait'] = "Vous avez déjà soumis votre diagnostic pour ce quiz. En attente de l'évaluation du professeur.";
    }

    // Après la récupération des données du quiz
    if (!isset($_SESSION['tentatives_par_quiz'][$quiz_id])) {
        $_SESSION['tentatives_par_quiz'][$quiz_id] = $quiz_data['tentative_max'];
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Une erreur est survenue lors de la récupération des données du quiz.";
    header('Location: quiz_espace_student.php');
    exit();
}

// Initialisation des variables de session 
if (!isset($_SESSION['messages'])) $_SESSION['messages'] = [];
if (!isset($_SESSION['nb_questions'])) $_SESSION['nb_questions'] = 0;

// Traitement de la question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question']) && $_SESSION['tentatives_par_quiz'][$quiz_id] > 0) {
    $question = trim($_POST['question']);
    
    // Préparation des données pour Flask
    $data = [
        'question' => $question,
        'themes_attendus' => $themes_disponibles
    ];
    
    
    // Configuration de la requête cURL
    $ch = curl_init('http://ai:5000/classify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Exécution de la requête
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

    
    if ($http_code === 200 && $response) {
        $result = json_decode($response, true);
        $theme_detecte = $result['theme_detecte'] ?? null;
        $confiance = $result['confidence'] ?? 0;
        
        // Définition des seuils
        $SEUIL_CAS_1 = 0.8;  // Seuil pour très bonne confiance
        $SEUIL_MIN = 0.5;    // Seuil minimum pour réponse du modèle
        
        // Cas 4 : Pas de thème détecté ou score trop faible
        if (!$theme_detecte || $confiance < $SEUIL_MIN) {
            $_SESSION['messages'][] = [
                "etudiant" => $question,
                "patient" => "Je ne saurais pas vous répondre.",
                "theme" => "hors_sujet",
                "confiance" => $confiance,
                "cas" => "cas_4"
            ];
        }
        // Cas 2 : Thème détecté mais hors thèmes attendus
        else if (!in_array($theme_detecte, $themes_disponibles)) {
            $_SESSION['messages'][] = [
                "etudiant" => $question,
                "patient" => "Je ne saurais pas vous répondre.",
                "theme" => $theme_detecte,
                "confiance" => $confiance,
                "cas" => "cas_2"
            ];
        }
        // Cas 1 ou 3 : Thème attendu avec confiance suffisante
        else {
            // Récupérer la réponse modèle depuis la base de données
            $query = "SELECT reponse_modele FROM qst_quiz_3 WHERE quiz3_id = ? AND theme = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$quiz_id, $theme_detecte]);
            $row = $stmt->fetch();
            
            if ($row && $row['reponse_modele']) {
                // Décoder le JSON des réponses modèles
                $reponses = json_decode($row['reponse_modele'], true);
                // Prendre la première réponse modèle
                $reponse = is_array($reponses) ? $reponses[0] : $row['reponse_modele'];
                
                // Ajouter le thème aux thèmes révélés s'il n'y est pas déjà
                if (!in_array($theme_detecte, $_SESSION['themes_reveles'])) {
                    $_SESSION['themes_reveles'][] = $theme_detecte;
                }
                
                // Déterminer le cas en fonction de la confiance
                $cas = ($confiance >= $SEUIL_CAS_1) ? 'cas_1' : 'cas_3';
                
                $_SESSION['messages'][] = [
                    "etudiant" => $question,
                    "patient" => $reponse,
                    "theme" => $theme_detecte,
                    "confiance" => $confiance,
                    "cas" => $cas
                ];
                
                // Enregistrer la question dans quiz_resultat3
                try {
                    $query = "INSERT INTO quiz_resultat3 (quiz3_id, student_id, question_posee, theme_revele, resultat) 
                             VALUES (?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        $quiz_id,
                        $student_id,
                        $question,
                        $theme_detecte,
                        $confiance
                    ]);
                } catch (PDOException $e) {
                    error_log("Erreur lors de l'enregistrement du résultat : " . $e->getMessage());
                }
            } else {
                // Thème trouvé mais pas de réponse modèle
                $_SESSION['messages'][] = [
                    "etudiant" => $question,
                    "patient" => "Je ne saurais pas vous répondre.",
                    "theme" => $theme_detecte,
                    "confiance" => $confiance,
                    "cas" => "cas_4"
                ];
            }
        }
    } else {
        // Erreur de communication avec Flask
        $_SESSION['messages'][] = [
            "etudiant" => $question,
            "patient" => "Je ne saurais pas vous répondre.",
            "theme" => "erreur",
            "confiance" => 0,
            "cas" => "cas_4"
        ];
    }
    
    // Décrémenter le nombre de tentatives
    $_SESSION['tentatives_par_quiz'][$quiz_id]--;
}

// Traitement du diagnostic final
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['diag_final'])) {
    $diag_final = test_input($_POST['diag_final']);
    
    // Préparer les questions avec des retours à la ligne
    $questions_array = array_map(function($msg) {
        return "- " . ($msg['etudiant'] ?? '');
    }, $_SESSION['messages']);
    $questions_concat = implode("\n", $questions_array);
    
    // Récupérer tous les thèmes révélés avec des retours à la ligne
    $themes_array = array_map(function($theme) {
        return "- " . $theme;
    }, $_SESSION['themes_reveles']);
    $themes_reveles = implode("\n", $themes_array);
    
    try {
        // Vérifier si une entrée existe déjà
        $check_query = "SELECT * FROM quiz_resultat3 WHERE quiz3_id = ? AND student_id = ?";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute([$quiz_id, $student_id]);

        $stmtCheck = $pdo->prepare($queryCheck);
        $stmtCheck->execute([$quiz_id, $student_id]);

        $test_deja_fait = ($stmtCheck->rowCount() > 0);
        
        if ($check_stmt->rowCount() > 0) {
            // Mise à jour de l'entrée existante
            $update_query = "UPDATE quiz_resultat3 
                           SET question_posee = ?,
                               theme_revele = ?,
                               diagnostic = ?,
                               date_de_passage = NOW(),
                               resultat = NULL
                           WHERE quiz3_id = ? AND student_id = ?";
            $stmt = $pdo->prepare($update_query);
            $result = $stmt->execute([$questions_concat, $themes_reveles, $diag_final, $quiz_id, $student_id]);
        } else {
            // Création d'une nouvelle entrée
            $insert_query = "INSERT INTO quiz_resultat3 
                           (quiz3_id, student_id, question_posee, theme_revele, diagnostic, date_de_passage, resultat)
                           VALUES (?, ?, ?, ?, ?, NOW(), NULL)";
            $stmt = $pdo->prepare($insert_query);
            $result = $stmt->execute([$quiz_id, $student_id, $questions_concat, $themes_reveles, $diag_final]);
        }

        if ($result) {
            // Réinitialiser les variables de session
            $_SESSION['messages'] = [];
            $_SESSION['nb_questions'] = 0;
            $_SESSION['themes_reveles'] = [];
            unset($_SESSION['tentatives_par_quiz'][$quiz_id]);
            
            $_SESSION['success'] = "✅ Diagnostic soumis avec succès. Le professeur vous notera bientôt.";
            header('Location: quiz_espace_student.php?etat=true');
            exit();
        } else {
            throw new PDOException("Erreur lors de l'enregistrement des données");
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "❌ Erreur lors de la sauvegarde du diagnostic : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Quiz Niveau 3 </title>
    <!--<link rel="stylesheet" href="static/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="static/css/style3.css">

</head>
<body>
    <?php
    
    include("traitement/navbar_student.php");
    ?>

    

    <div class="chat-container">
        <div class="chat-header">
            <div class="cas-description">
                <strong>Description du cas :</strong><br>
                <?= htmlspecialchars($quiz_data['description'] ?? 'Description non disponible') ?>
            </div>

            <div class="themes-a-decouvrir">
                <?php
                $nb_total_themes = count($themes_disponibles);
                $nb_themes_reveles = count($_SESSION['themes_reveles']);
                
                // Calculer le nombre de thèmes à découvrir (ne peut pas être négatif)
                $nb_themes_a_decouvrir = max(0, $nb_total_themes - $nb_themes_reveles);
                ?>
                <strong>Thèmes à découvrir :</strong> <?= $nb_themes_a_decouvrir ?><br>
                <strong>Thèmes découverts :</strong>
                <?php if ($nb_themes_reveles > 0): ?>
                    <?= implode(", ", array_map('htmlspecialchars', $_SESSION['themes_reveles'])) ?>
                <?php else: ?>
                    <em>Aucun thème découvert pour le moment</em>
                <?php endif; ?>
            </div>

            <div class="compteur">
                <strong>Tentatives restantes :</strong> <?= $_SESSION['tentatives_par_quiz'][$quiz_id] ?>
            </div>
        </div>

        <div class="chat-history" id="chat">
            <?php foreach ($_SESSION['messages'] as $msg): ?>
                <div class="message etudiant">🧑‍🎓 <?= htmlspecialchars($msg['etudiant']) ?></div>
                <div class="message patient <?php
                    $cas = isset($msg['cas']) ? $msg['cas'] : 'default';
                    switch($cas) {
                        case 'cas_1':
                            echo 'message-success';  // Vert - Très bonne confiance
                            break;
                        case 'cas_2':
                            echo 'message-error';    // Rouge - Hors thème attendu
                            break;
                        case 'cas_3':
                            echo 'message-warning';  // Orange - Confiance moyenne
                            break;
                        case 'cas_4':
                            echo 'message-neutral';  // Gris - Réponse neutre
                            break;
                        default:
                            echo 'message-info';
                    }
                ?>">
                    <?php 
                    if (!isset($msg['patient'])) {
                        echo '❗ Message non disponible';
                    } else {
                        if ($cas === 'cas_1'): ?>
                            ✅ <?= htmlspecialchars($msg['patient']) ?>
                        <?php elseif ($cas === 'cas_2'): ?>
                            ❌ <?= htmlspecialchars($msg['patient']) ?>
                        <?php elseif ($cas === 'cas_3'): ?>
                            ❓ <?= htmlspecialchars($msg['patient']) ?>
                        <?php elseif ($cas === 'cas_4'): ?>
                            ℹ️ <?= htmlspecialchars($msg['patient']) ?>
                        <?php else: ?>
                            ❗ <?= htmlspecialchars($msg['patient']) ?>
                        <?php endif;
                    } ?>
                </div>
            <?php endforeach; ?>
        </div>

 <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="confirmation"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>


    <?php if (!$test_deja_fait): ?>
        <?php if ($_SESSION['tentatives_par_quiz'][$quiz_id] > 0): ?>
            <form method="post" class="input-form">
                <input type="text" name="question" placeholder="Posez votre question..." required autofocus>
                <button type="submit">Envoyer</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">
                Vous avez utilisé toutes vos tentatives.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form method="post" class="diag-form">
        <label for="diag_final"><strong>📝 Diagnostic final :</strong></label>
        <input type="text" name="diag_final" id="diag_final" required <?= $test_deja_fait ? 'disabled' : '' ?>>
        <button type="submit" <?= $test_deja_fait ? 'disabled' : '' ?>>Soumettre</button>
    </form>
    </div>
    <?php include("traitement/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.input-form');
        if (!form) return; // Si le formulaire n'existe pas, on ne fait rien

        const input = form.querySelector('input[name="question"]');
        const button = form.querySelector('button[type="submit"]');
        let submitted = false;

        // Empêcher la soumission multiple via le bouton ou la touche Entrée
        form.addEventListener('submit', function (e) {
            if (submitted) {
                e.preventDefault(); // Empêche soumission multiple
                return;
            }
            submitted = true;
            button.disabled = true;
            button.innerText = "⏳ Envoi...";
        });

        // Éviter la soumission multiple via Entrée rapide
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && submitted) {
                e.preventDefault();
            }
        });
    });
    const chatHistory = document.getElementById('chat');
    chatHistory.scrollTop = chatHistory.scrollHeight;
    </script>

</body>
</html>
