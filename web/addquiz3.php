<?php
session_start();
include("traitement/navbar_teacher.php");
include("traitement/function.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="static/css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="static/css/quiz.css">-->
    <title>Ajouter Quiz Niveau 3</title>
</head>
<body>

<?php if (isset($_GET['etat']) && $_GET['etat'] == 'true') : ?>
    <div class="alert alert-success">
        <i class="far fa-check-square"></i> L'opération s'effectue avec <strong>Succès!</strong>
    </div>
    <script>
        setTimeout(function(){
            window.location.href = 'addquiz3.php';
        }, 2000);
    </script>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <h5 class="card-header">Ajouter le Cas Clinique</h5>
                <div class="card-body">
                    <form method="POST" action="traitement/insertqst3.php" id="quiz-form">
                        
                        <label for="titre_quiz">Titre du quiz :</label>
                        <input type="text" id="titre_quiz" name="nom_quiz" class="form-control" required>

                        
                        <label for="tentatives">Nombre de tentatives :</label>
                        <input type="number" id="tentatives" name="tentative_max" class="form-control" min="1" value="1" required>

                        <label for="description">Description :</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Veuillez decrire le cas clinique" required></textarea>

                        <div id="themes-container">
                            <div class="theme-block border rounded p-3 my-3" data-theme-index="0">
                                <label>Sélectionner un thème :</label>
                                <select name="theme[]" class="form-control theme-select" required>
                                    <option value=""> Sélectionner un thème</option>
                                    <option value="antécédents cardiovasculaires">Antécédents cardiovasculaires</option>
                                    <option value="douleur thoracique">Douleur thoracique</option>
                                    <option value="durée">Durée</option>
                                    <option value="facteurs calmants">Facteurs calmants</option>
                                    <option value="facteurs déclenchants">Facteurs déclenchants</option>
                                    <option value="irradiation">Irradiation</option>
                                    <option value="résultats d'examen">Résultats d'examen</option>
                                    <option value="traitements en cours">Traitements en cours</option>
                                </select>

                                <div class="mt-3"></div>

                                <div class="questions-container mt-3">
                                    <div class="question-set">
                                        <label>Question modèle :</label>
                                        <input type="text" name="question0[]"  class="form-control" placeholder="Veuillez respecter les thèmes choisis" required>

                                        <label>Réponse attendue du patient :</label>
                                        <input type="text" name="reponse0[]" class="form-control" placeholder="Veuillez respecter les thèmes choisis" required>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-danger mt-3" onclick="supprimerBlocTheme(this)">❌ Supprimer ce thème</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" onclick="ajouterBlocTheme()">Ajouter un thème</button>

                        <div class="mt-4"></div>
                        <label for="diagnostic">Diagnostic final :</label>
                        <input type="text" id="diagnostic" name="diagnostic" class="form-control" required>

                        <input type="submit" value="Ajouter" class="btn btn-info mt-3 float-right">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function ajouterBlocTheme() {
    const container = document.getElementById('themes-container');
    const blocIndex = container.children.length;
    
    // Créer un nouveau bloc vide
    const newBloc = document.createElement('div');
    newBloc.className = 'theme-block border rounded p-3 my-3';
    newBloc.setAttribute('data-theme-index', blocIndex);
    
    // Ajouter le contenu HTML du nouveau bloc
    newBloc.innerHTML = `
        <label>Sélectionner un thème :</label>
        <select name="theme[]" class="form-control theme-select" required>
            <option value=""> Sélectionner un thème</option>
            <option value="antécédents cardiovasculaires">Antécédents cardiovasculaires</option>
            <option value="douleur thoracique">Douleur thoracique</option>
            <option value="durée">Durée</option>
            <option value="facteurs calmants">Facteurs calmants</option>
            <option value="facteurs déclenchants">Facteurs déclenchants</option>
            <option value="irradiation">Irradiation</option>
            <option value="résultats d'examen">Résultats d'examen</option>
            <option value="traitements en cours">Traitements en cours</option>
        </select>

        <div class="mt-3"></div>
        
        <div class="questions-container mt-3">
            ${genererBlocQuestionHTML(blocIndex, 1)}
        </div>

        <button type="button" class="btn btn-danger mt-3" onclick="supprimerBlocTheme(this)">❌ Supprimer ce thème</button>
    `;

    container.appendChild(newBloc);
}

function supprimerBlocTheme(btn) {
    const container = document.getElementById('themes-container');
    if (container.children.length > 1) {
        btn.closest(".theme-block").remove();
        reindexerBlocs();
    } else {
        alert("Au moins un thème est requis.");
    }
}

function reindexerBlocs() {
    const container = document.getElementById('themes-container');
    Array.from(container.children).forEach((bloc, index) => {
        // Mettre à jour l'index du bloc
        bloc.setAttribute('data-theme-index', index);
        
 
        
        // Mettre à jour les noms des champs
        const questionsContainer = bloc.querySelector('.questions-container');
        const nbQuestions = parseInt(nbInput.value) || 1;
        questionsContainer.innerHTML = genererBlocQuestionHTML(index, nbQuestions);
    });
}

function genererQuestions(input, blocIndex) {
    const nb = Math.max(parseInt(input.value) || 1, 1);
    input.value = nb;
    const container = input.closest('.theme-block').querySelector('.questions-container');
    container.innerHTML = genererBlocQuestionHTML(blocIndex, nb);
}

function genererBlocQuestionHTML(blocIndex, nb) {
    let html = "";
    for (let i = 0; i < nb; i++) {
        html += `
            <div class="question-set mt-3">
                <label>Question modèle :</label>
                <input type="text" name="question${blocIndex}[]" class="form-control" placeholder="Veuillez respecter les thèmes choisis" required>

                <label>Réponse attendue du patient :</label>
                <input type="text" name="reponse${blocIndex}[]" class="form-control" placeholder="Veuillez respecter les thèmes choisis" required>
            </div>
        `;
    }
    return html;
}
</script>

<?php include("traitement/footer.php"); ?>

</body>
</html>