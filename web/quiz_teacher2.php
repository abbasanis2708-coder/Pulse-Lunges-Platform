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

	<title>Quiz</title>

</head>

<body>

	<?php

      include("traitement/navbar_teacher.php");

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

if (!isset($_POST['id'])) {
  
  echo '<script language="Javascript"> document.location.replace("quiz_espace_teacher.php"); </script>';
}else{

$id_quiz = $_POST['id'];
}




$query = "select count(quiz2_id) as nbr from qst_quiz_2 where quiz2_id = ?";

$values = array($id_quiz);

$stm = PDO($query,$values);



if ($stm->rowCount()!=0) {

  while ($row = $stm->fetch()) {

    $nbr_qst = $row['nbr'];

  }

}



echo '<form action="traitement/quiztrait2.php" method="post">';

  
echo '<input type="hidden"  name="id" value="'.$id_quiz.'" >';
  

  

$q=1;

echo '<h1 class="card-title" style="margin-left: 44%; ">Quiz</h1><br><br>';

while($q<=$nbr_qst){
  

  $query = "SELECT * from qst_quiz_2 where quiz2_id = ? and n_question = ?" ;
  $value = array($id_quiz,$q);
  $res = PDO($query,$value);

  


  $rep = array();

  if ($res->rowCount()!=0) {

    while($row = $res->fetch()){
      
      
      $cas_clinique= $row['cas_clinique'];
      $question  = $row['question_text'];
      $c1  = $row['age'];
      $c2  = $row['sexe'];
      $c4  = $row['condition_physique'];
      $c5  = $row['examen'];
      $c6  = $row['diagnostics_passes_et_actuels'];
      $c7  = $row['poids'];
      $c8  = $row['frequence_cardiaque'];
      $c9 = $row['fonction_cardiaque'];
      $c10  = $row['lieu_l_auscultation_cardiaque'];
      $c11  = $row['antecedents_medicaux_familiaux'];
      array_push($rep, $row['option_1']);
      array_push($rep, $row['option_2']);
      array_push($rep, $row['option_3']);
      array_push($rep, $row['option_4']);
      shuffle($rep);

      echo '
      
      
      
    <p class="card-text"><b>Case Study:</b> '.$cas_clinique.'</p>
    <p class="card-text"><b>Age:</b> '.$c1.'</p>
    <p class="card-text"><b>Sexe:</b> '.$c2.'</p>
    <p class="card-text"><b>condition physique:</b> '.$c4.'</p>
    <p class="card-text"><b>examen:</b> '.$c5.'</p>
    <p class="card-text"><b>diagnostics passes et actuels:</b> '.$c6.'</p>
    <p class="card-text"><b>poids: </b>'.$c7.'</p>
    <p class="card-text"><b>frequence cardiaque: </b> '.$c8.'</p>
    <p class="card-text"><b>fonction cardiaque:</b> '.$c9.'</p>
    <p class="card-text"><b>lieu de l auscultation cardiaque:</b> '.$c10.'</p>
    <p class="card-text"><b>antecedents medicaux familiaux:</b> '.$c11.'</p>';
    // affichage audio
      $query1 = "SELECT * from quiz_audio where quiz2_id = ? and qst_id = ?" ;
      $value1 = array($id_quiz,$row['qst_id']);
      $res1 = PDO($query1,$value1);

      if ($res1->rowCount()!=0){
        while($rou = $res1->fetch()){
          $audio_file = $rou['audio_file'];
          echo'<audio controls>
          <source src="./static/audio/'.$audio_file.'" type="audio/mpeg">
          Your browser does not support the audio element.
    </audio><br>';
        }

      }
    echo'<p class="card-text"style="font-size:20pt;"><b>Question '.$q.': '.$question.'</b></p>
    
    
    
';


      foreach ($rep as $r) {

        echo '<input type="checkbox" value="' .$r. '"  name="' .$q. '" class="quizs">' .$r. '<br>';

      }

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







<br>





<!---------------------------------------------------------------------------------------------------->

 	<?php

	  include("traitement/footer.php");

	?> 



</body>

</html>

