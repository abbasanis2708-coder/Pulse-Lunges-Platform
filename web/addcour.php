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

	<title>Ajouter Cours</title>

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
                  window.location.href = \'addcour.php\';
               }, 2000);
            </script>
            ';
          }else{
            echo '<div class="alert alert-danger">
                      <i class="fas fa-times"></i> <strong>Error !<strong> l\'hors de l\'opération ! .
                  </div>
                  <script>
                     setTimeout(function(){
                        window.location.href = \'addcour.php\';
                     }, 2000);
                  </script>
                  ';

          }
      }
?>

<?php

echo '

<br><div class="container">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="card">

                    <h5 class="card-header">Ajouter le Cours</h5>

                    <div class="card-body">

    ';



    

    echo'<form action="traitement/insertcour.php" method="post">
          

          ';

    echo'<div class="form-group row">

                        <label for="inputTitre" class="col-sm-2 col-form-label">Titre Cours</label>

                        <div class="col-sm-8">

                        <input type="text" name="titre" class="form-control" id="inputtitre">

                        </div>

         </div>

';

         /*Question area*/

    echo '<div class="col-lg-12 col-md-12 col-sm-12">

          

          ';



            echo '
                <div class="card">
                    <div class="card-body">
                        Cours  :
                    </div>
                    <textarea style="margin: 10px; height: 200px; padding-top: 10px;" name="description" class="form-control" id="exampleFormControlInput1" placeholder="Contenu du cours"></textarea><br>                                
                  <div id="audioContainer"></div>
            <button type="button" id="addAudioButton" class="btn btn-primary" onclick="addAudioField()"">Ajouter un fichier audio</button>
        </div>
        <input type="hidden" name="audioCount" id="audioCountInput" value="">


                  ';
                 

           



    

        echo ' 

                </div>';

        /*End Question area*/



     echo '<input type="submit" value="Ajouter" class="btn btn-info float-right" >';

echo '</form>';













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
    // Check if audioCount is stored in session storage, otherwise initialize it to 1
    var audioCount = sessionStorage.getItem('audioCount') || 1;

    // Function to add a new audio field
    function addAudioField() {
        var audioContainer = document.getElementById("audioContainer");
        var audioField = document.createElement("input");
        audioField.type = "file";
        audioField.name = "audio_file_" + audioCount;
        audioField.className = "form-control";
        audioField.style.margin = "0px 10px 10px 10px";
        audioField.accept = "audio/*";
        audioField.placeholder = "Sélectionnez un fichier audio";
        audioContainer.appendChild(audioField);
        audioCount++;
        document.getElementById("audioCountInput").value = audioCount;
        sessionStorage.setItem('audioCount', audioCount); // Store audioCount in session storage
    }
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

