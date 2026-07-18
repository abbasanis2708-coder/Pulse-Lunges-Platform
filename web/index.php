

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="static/css/bootstrap.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="stylesheet" href="static/css/Style_NF.css">

    <link rel="stylesheet" href="static/css/index.css">

    <link rel="icon" type="image/png" href="/static/img/logo.png">

    <title> Pulse Lunges Apprentissage</title>

</head>

<body>

  <!--Begin of NavBar-->

 <?php
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 include("traitement/navbar_index.php");

 ?>

 

 

  <!--END Nav bar-->

  <!-- Wall -->

  <article id="myinfo">

   <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">

      <div class="carousel-inner">

      <?php

      /*cette partie sert pour qfficher tous les photos qui sont dans le dossier /img/wall/ pour eviter la repitition du code n fois */



       $dir = opendir("static/img/index/wall/");

       $i=1;

       while ($file = readdir($dir)){

           if ($file != "." && $file != ".."){

                if($i==1){

                  echo '<div class="carousel-item active">

                  <img style="filter: blur(7px);"src="static/img/index/wall/'.$file.'" class="d-block w-100 mysize" alt="...">

                      <div style="color:bleu;"class="carousel-caption d-none d-md-block">

                        <h2>Pulse Lunges Apprentissage</h2>

                        <h4>Apprentissage auditif</h4>

                      </div>

                 </div>';

                }else{

                echo '<div style="filter: blur(4px);" class="carousel-item">

                        <img src="static/img/index/wall/'.$file.'" class="d-block w-100 mysize" alt="...">

                      </div>';

                }

                $i++;

            }

       }



      ?>

      <?php

      
      $j=1;

      echo '<ol class="carousel-indicators">';

      while($j<$i){

        if ($j==1) {

          echo '<li data-target="#carouselExampleCaptions" data-slide-to="1" class="active"></li>';

        }

        else {

          echo '<li data-target="#carouselExampleCaptions" data-slide-to="'.$j.'" class="active"></li>';

        }

        $j++;

      }

      echo '</ol>';

      ?>

      </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">

          <span class="carousel-control-prev-icon" aria-hidden="true"></span>

          <span class="sr-only">Previous</span>

        </a>

        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">

          <span class="carousel-control-next-icon" aria-hidden="true"></span>

          <span class="sr-only">Next</span>

        </a>

    </div>

  </article>

  <!-- End wall -->

  <!-- Carctéristique --> 
  <?php

include("traitement/function.php");

?>

<br>

<br>

<br>

<!-- <br>

<br>

<br>

<br>

<br>

<br> -->

<!---------------------------------------------------------------------------------------------------->

<div class="container">

<div class="row">

<div class="col-lg-12 col-md-12 col-sm-12">

  <div class="card">

    <div class="card-body">

<?php





$query = "select count(cours_id) as nbr from cours ";

$values = array();

$stm = PDO($query,$values);



if ($stm->rowCount()!=0) {

while ($row = $stm->fetch()) {

$nbr_cours = $row['nbr'];

}

}



echo '<form >';


 




$q=1;

echo '<h1 class="card-title" style="margin-left: 44%; ">Cours</h1><br><br>';
$query = "SELECT * from cours " ;
$value = array();
$res = PDO($query,$value);

while($q<=$nbr_cours){









if ($res->rowCount()!=0) {

while($row = $res->fetch()){


$nom_cours= $row['nom_cours'];
$description  = $row['description'];


echo '



<p class="card-text"style="font-size:20pt;"><b> '.$nom_cours.'</b></p>
';
// affichage audio
$query1 = "SELECT * from cours_audio where cours_id = ? " ;
$value1 = array($row['cours_id']);
$res1 = PDO($query1,$value1);

if ($res1->rowCount()!=0){
  $i=1;
  while($rou = $res1->fetch()){
    $audio_file = $rou['audio_file'];
    echo'<p><b>Audio '.$i.'</b></p>
    <audio controls>
    <source src="./static/audio/'.$audio_file.'" type="audio/mpeg">
    Your browser does not support the audio element.
</audio><br>';
$i++;
  }

}
echo'<p class="card-text"style="font-size:20pt;"><b>Description</b><br>'.$description.'</p>



';


echo '

<br><hr>';



}

}

$q++;

}





?>

<br>


</form>

  
</div>

</div>

</div>

</div>

</div>

  

  

  <!--Fotter,script and Contact form-->




  <?php

  include("traitement/footer.php");

  ?>                                                                                      
  </body>

</html>