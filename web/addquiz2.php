<?php

session_start();

?>

<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="static/css/bootstrap.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="stylesheet" href="static/css/quiz.css">

	<title>Ajouter Quiz</title>

</head>

<body>

	<?php

      include("traitement/navbar_teacher.php");

      include("traitement/function.php");

 	?>

<?php
      if (isset($_GET['etat'])) {
        if($_GET['etat']=="true"){
          echo '
            <div class="alert alert-success">
              <i class="far fa-check-square"></i> L\'opération s\'effectue avec <strong>Success!</strong>
            </div>
            <script>
               setTimeout(function(){
                  window.location.href = \'addquiz2.php\';
               }, 2000);
            </script>
            ';
          }else{
            echo '<div class="alert alert-danger">
                      <i class="fas fa-times"></i> <strong>Error !<strong> l\'hors de l\'opération ! .
                  </div>
                  <script>
                     setTimeout(function(){
                        window.location.href = \'addquiz2.php\';
                     }, 2000);
                  </script>
                  ';

          }
      }
?>

<?php

echo '

    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="card">

                    <h5 class="card-header">Ajouter le Quiz</h5>

                    <div class="card-body">

    ';
if (isset($_POST['number'])) {

    if (empty($_POST['number'])) {

        header("location: addquiz2.php");

    }

    $n = $_POST['number'];


    

    echo'<form action="traitement/insertqst2.php" method="post">
          <input type="hidden" name="qst" value="'.$n.'">
          

          ';

    echo'<div class="form-group row">

                        <label for="inputTitre" class="col-sm-2 col-form-label">Titre Quiz</label>

                        <div class="col-sm-8">

                        <input type="text" name="titre" class="form-control" id="inputtitre">

                        </div>

         </div>

';

         /*Question area*/

    echo '<div class="col-lg-12 col-md-12 col-sm-12">

          

          ';



          for ($i = 1; $i <= $n; $i++) {
            echo '
                <div class="card">
                    <div class="card-body">
                        Question ' . $i . ' :
                    </div>
                    <input type="text" style="margin: 10px;" name="question' . $i . '" class="form-control" id="exampleFormControlInput1" placeholder="Question">

                 <input type="text" style="margin: 10px;" name="option_correct'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="nombre de reponse correcte">

                  <input type="text" style="margin: 10px;" name="option_1'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Reponse 1">

                  <input type="text" style="margin: 10px;" name="option_2'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Réponse 2">

                  <input type="text" style="margin: 10px;" name="option_3'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Réponse 3">

                  <input type="text" style="margin: 10px;" name="option_4'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Réponse 4">

                  <input type="text" style="margin: 10px;" name="cas_clinique'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Cas clinique">

                  <input type="text" style="margin: 10px;" name="age'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Age">

                  <select class="form-control" style="margin: 10px;" name="sexe'.$i.'" id="exampleFormControlSelect1">
                    <option value="" disabled selected hidden>Sélectionnez le sexe</option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                  </select>

                  <select class="form-control" style="margin: 10px;" name="condition_physique'.$i.'" id="exampleFormControlSelect1">
                    <option value="" disabled selected hidden>Sélectionnez condtion physique</option>
                    <option value="actif">Actif</option>
                    <option value="calme">calme</option>
                  </select>

                  <select class="form-control" style="margin: 10px;" name="examen'.$i.'" id="exampleFormControlSelect1">
                    <option value="" disabled selected hidden>Sélectionnez exmamen</option>
                    <option value="Normal">Normal</option>
                    <option value="Anormal">Anormal</option>
                  </select>

                  <input type="text" style="margin: 10px;" name="diagnostics_passes_et_actuels'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="les diagnostics passés et actuels">

                  <input type="text" style="margin: 10px;" name="poids'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Poids">

                  <input type="text" style="margin: 10px;" name="masse_corporelle'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Masse corporelles">

                  <input type="text" style="margin: 10px;" name="frequence_cardiaque'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Frequence cardiaque">

                  <input type="text" style="margin: 10px;" name="fonction_cardiaque'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Fonction cardiaque">

                  <input type="text" style="margin: 10px;" name="lieu_auscultation_cardiaque'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="le lieu de l auscultation cardiaque">

                  <input type="text" style="margin: 10px;" name="antecedents_medicaux_familiaux'.$i.'" class="form-control" id="exampleFormControlInput1" placeholder="Antécédents médicaux familliare">
                  
                  <div id="audioContainer' . $i . '"></div>
            <button type="button" id="addAudioButton' . $i . '" class="btn btn-primary" onclick="addAudioField(' . $i . ')"">Ajouter un fichier audio</button>
        </div>
        <input type="hidden" name="audioCount' . $i . '" id="audioCountInput' . $i . '" value="">

                  ';
                 

           



    }

        echo ' 

                </div>';

        /*End Question area*/



     echo '<input type="submit" value="Ajouter" class="btn btn-info float-right" >';

echo '</form>';





}else{

echo '

<form method="POST"> 

<div class="form-group row">

                        <label for="inputTitre" class="col-sm-2 col-form-label">Nombre des questions : </label>

                        <div class="col-sm-8">

                        <input type="number" class="form-control"  id="number" name="number" placeholder="ex: 4">

                        </div>

         </div> 



<input type="submit" value="Suivant" class="btn btn-info float-right" onclick="numberquestion()"/>  

</form> 

';





}

echo '              </div>

                </div>

            </div>

        </div>

    </div>



';





?>


<!---------------------------------------------------------------------------------------------------->  



 

<!---------------------------------------------------------------------------------------------------->
<script>
    var audioCounts = {}; // Tableau pour stocker les compteurs d'audio pour chaque question

    // Fonction pour ajouter un nouveau champ de fichier audio
    function addAudioField(questionNumber) {
        // Vérifier si le compteur pour la question existe, sinon le créer et l'initialiser à 1
        if (!audioCounts.hasOwnProperty(questionNumber)) {
            audioCounts[questionNumber] = 1;
        }

        // Sélectionner le conteneur des fichiers audio spécifique à la question
        var audioContainer = document.getElementById("audioContainer" + questionNumber);

        // Créer un nouvel élément input de type "file"
        var audioField = document.createElement("input");
        audioField.type = "file";
        audioField.name = "audio_file" + questionNumber + '_' + audioCounts[questionNumber];
        audioField.className = "form-control";
        audioField.style.margin = "0px 10px 10px 10px";
        audioField.accept = "audio/*";
        audioField.placeholder = "Sélectionnez un fichier audio";

        // Ajouter le nouvel élément au conteneur
        audioContainer.appendChild(audioField);
        audioCounts[questionNumber]++; // Incrémenter le compteur pour la question
        document.getElementById("audioCountInput" + questionNumber).value = audioCounts[questionNumber];
    }

    // Fonction pour mettre à jour les valeurs de audioCounts dans les champs de formulaire
    function updateAudioCountInputs() {
        var audioCountInputs = document.querySelectorAll("input[name^='audioCount']");
        audioCountInputs.forEach(function(input) {
            var questionNumber = input.getAttribute("data-question");
            input.value = audioCounts[questionNumber];
        });
    }

    // Événement de soumission du formulaire pour mettre à jour les champs de formulaire avant l'envoi
    document.querySelector("form").addEventListener("submit", function() {
        updateAudioCountInputs();
    });
</script>
 	<script type="text/javascript">  

        function numberquestion(){  



        var number=document.getElementById("number").value; 



        document.location.replace("random.php?"+number);



        }  

    </script> 

    <?php

	  include("traitement/footer.php");

	?> 



</body>

</html>

