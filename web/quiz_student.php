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

      include("traitement/navbar_student.php");

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
  echo '<script language="Javascript"> document.location.replace("quiz_espace_student.php"); </script>';
} else {
  $id_quiz = $_POST['id'];
  
  // Vérifier si l'étudiant a déjà fait ce quiz
  $query = "SELECT * FROM quiz_resultat1 WHERE quiz1_id = ? AND student_id = ?";
  $result = PDO($query, array($id_quiz, $_SESSION['student_id']));
  
  if ($result->rowCount() > 0) {
    // L'étudiant a déjà fait ce quiz
    echo '<script language="Javascript"> document.location.replace("quiz_espace_student.php?etat=test"); </script>';
    exit();
  }
}




$query = "select count(quiz1_id) as nbr from qst_quiz_1 where quiz1_id = ?";

$values = array($id_quiz);

$stm = PDO($query,$values);



if ($stm->rowCount()!=0) {

  while ($row = $stm->fetch()) {

    $nbr_qst = $row['nbr'];

  }

}



echo '<form action="traitement/quiztrait1.php" method="post">';

  
echo '<input type="hidden"  name="id" value="'.$id_quiz.'" >';
  

  

$q=1;

echo '<h1 class="card-title" style="margin-left: 44%; ">Quiz</h1>';

while($q<=$nbr_qst){

  $query = "SELECT * from qst_quiz_1 where quiz1_id = ? and n_question = ?" ;

    

  $value = array($id_quiz,$q);

  $res = PDO($query,$value);



  $rep = array();

  if ($res->rowCount()!=0) {

    while($row = $res->fetch()){

      $cas_clinique = $row['cas_clinique'];
      $audio_file = $row['audio_file'];
      $question  = $row['question_text'];

      array_push($rep, $row['option_1']);

      array_push($rep, $row['option_2']);

      array_push($rep, $row['option_3']);

      array_push($rep, $row['option_4']);



      shuffle($rep);

      echo '
      <p class="card-text"><b>Cas clinique:</b> '.$cas_clinique.'</p>
      <audio controls>
          <source src="./static/audio/'.$audio_file.'" type="audio/mpeg">
          Your browser does not support the audio element.
      </audio>
      
      <p class="card-text"style="font-size:20pt;"><b>Question '.$q.': '.$question.'</b></p>
      
  ';
       

      foreach ($rep as $r) {

        echo '<input type="radio" value="'.$r.'"  name="'.$q.'" class="quizs">'.$r.'<br>';

      }

      echo '

      <br><hr>';



    }

  }



$q++;

}

  

  

  ?>

    <br>

    <input type="submit" name="submit" class="btn btn-success float-right">

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

