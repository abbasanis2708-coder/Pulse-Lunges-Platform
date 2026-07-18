<?php

  session_start();

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="static/css/bootstrap.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="stylesheet" href="static/css/index.css">

    <link rel="stylesheet" href="static/css/cours-espace.css">

    <title>Evaluation Espace</title>

</head>

<body>

  <!--Begin of NavBar-->

<?php

  include("traitement/navbar_teacher.php");

  include("traitement/function.php");

  //

  capterConnexion($_SESSION['teacher_id']);
?>

  <!--END Nav bar-->



    

    <!-- Type Donnes Section -->

    <ul class="nav nav-pills nav-fill tab">
      <li class="nav-item">
        <button type="button" style="margin-left: 70%;" class="btn btn-link tablinks" onclick="openCity(event, 'quiz1')" id="defaultOpen" >Quiz niveau 1</button>
      </li>
      <li class="nav-item">
        <button type="button" class="btn btn-link tablinks" onclick="openCity(event, 'quiz1')" ></button>
      </li>
      <li class="nav-item">
        <button type="button" style="margin-left: 60%;" class="btn btn-link tablinks" onclick="openCity(event, 'quiz2')" >Quiz niveau 2</button>
      </li>
      <li class="nav-item">
        <button type="button" class="btn btn-link tablinks" onclick="openCity(event, 'quiz2')" ></button>
      </li>
      <li class="nav-item">
        <button type="button" style="margin-left: 50%;" class="btn btn-link tablinks" onclick="openCity(event, 'quiz3')">Quiz niveau 3</button>
      </li>
      <li class="nav-item">
        <button type="button" class="btn btn-link tablinks" onclick="openCity(event, 'quiz3')"></button>
      </li>
    </ul>

    <?php
        echo '<div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-center align-items-center my-4">
                            <a href="chose_lvl_quiz.php" class="btn btn-info px-4">Ajouter Quiz</a>
                        </div>
                    </div>
                </div>
              </div>';
    ?>

    <!-- Type De quiz -->

   

  <section class="Posts">

  




  <?php



  /***********************************************************/

  /*                traitement pour QUIZ  1                  */

  /*********************************************************/

    echo "<div id=\"quiz1\" class=\"tabcontent\">";
     

        

        

/*si c'est un quiz1*/



          $query8 = "Select * from quiz1 where teacher_id = ?  order by quiz1_id desc";

          $values8 = array($_SESSION['teacher_id']);

          $stm8 = PDO($query8,$values8);

          if ($stm8->rowCount()!=0) {

            while ($row = $stm8->fetch()) {

  echo'

  <div class="container">

  <div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

      <div class="card text-center cardpadding">

        <div class="card-body">

          <div class="media">

            <img src="static/img/cours espace/undraw_files1_9ool.svg" class="align-self-start mr-3 pdfsize" alt="pdf png image">

              <div class="media-body"> 
               
                <div class="d-flex flex-column" style="width: fit-content; margin: 0 auto;">
                  <h4 class="mt-0">Quiz : '.test_input($row['nom_quiz']).'</h4>
                  <div class="d-flex justify-content-center gap-2 mb-3">
                    <form method="post" action="quiz_teacher.php" class="mx-1">
                      <input type="hidden" name="id" value="'.test_input($row['quiz1_id']).'">
                      <button type="submit" class="btn btn-outline-primary">Consulter</button>
                    </form>
                    <form method="post" action="traitement/dropquiz1.php" class="mx-1">
                      <input type="hidden" name="id" value="'.test_input($row['quiz1_id']).'">
                      <button type="submit" class="btn btn-outline-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet QUIZ ?\')">Supprimer</button>
                    </form>
                  </div>

                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse_'.$row['quiz1_id'].'"
                    aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-sort-down fa-2x"></i> Étudiants Résultats
                  </button>
                </div>

                <div class="collapse" id="collapse_'.$row['quiz1_id'].'">
                  <div class="card card-body">
                    <table class="table">
                      <thead>
                        <tr class="trst">
                          <th scope="col" class="center">Nom d\'étudiant</th>
                          <th scope="col" class="center">Nombre de réponses correctes</th>
                        </tr>
                      </thead>
                      <tbody>

                ';

                  $qr = "SELECT * from quiz_resultat1 where quiz1_id=?";

                  $val = array($row['quiz1_id']);

                  $stm = PDO($qr,$val);

                  if ($stm->rowCount()!=0) {

                    while($row = $stm->fetch()){

                                  $id_etd = $row['student_id'];

                                  $q = "SELECT name as nom_etd from student where student_id = ?";

                                  $v = array($id_etd);

                                  $r = PDO($q,$v);

                                  if ($r->rowCount()!=0) {

                                    while($rw = $r->fetch()){

                                      $nom_etd = test_input($rw['nom_etd']);

                                    }

                                  }

                                  $reslt=$row['resultat'];
                                  $reslt1=$reslt-1;

                              echo '<tr>

                                    <td>'.$nom_etd.'</td>

                                    <td>'.$reslt1.'</td>

                                    ';

                    }

                  }else{

                    echo "<td>acune resultat est disponible pour le moment</td>";

                  }



                  

                echo '

                      </tbody>

                      </table>

                      </div>

                      </div>

                </p>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

</div>

  

  ';

     }

    } else {

      echo "<div class='container'><div class='alert alert-info'>Aucun quiz niveau 1 pour l'instant.</div></div>";

    }



        /*traitement si c'est un proffesseur*/

      echo "</div>";

  ?>
   <?php



/***********************************************************/

/*                traitement pour QUIZ  2                  */

/*********************************************************/

  echo "<div id=\"quiz2\" class=\"tabcontent\">";
   

      

      

/*si c'est un quiz1*/



        $query8 = "Select * from quiz2 where teacher_id = ?  order by quiz2_id desc";

        $values8 = array($_SESSION['teacher_id']);

        $stm8 = PDO($query8,$values8);

        if ($stm8->rowCount()!=0) {

          while ($row = $stm8->fetch()) {

echo'

<div class="container">

<div class="row">

  <div class="col-lg-12 col-md-12 col-sm-12">

    <div class="card text-center cardpadding">

      <div class="card-body">

        <div class="media">

          <img src="static/img/cours espace/undraw_files1_9ool.svg" class="align-self-start mr-3 pdfsize" alt="pdf png image">

            <div class="media-body"> 
             
              <div class="d-flex flex-column" style="width: fit-content; margin: 0 auto;">
                <h4 class="mt-0">Quiz : '.test_input($row['nom_quiz']).'</h4>
                <div class="d-flex justify-content-center gap-2 mb-3">
                  <form method="post" action="quiz_teacher2.php" class="mx-1">
                    <input type="hidden" name="id" value="'.test_input($row['quiz2_id']).'">
                    <button type="submit" class="btn btn-outline-primary">Consulter</button>
                  </form>
                  <form method="post" action="traitement/dropquiz2.php" class="mx-1">
                    <input type="hidden" name="id" value="'.test_input($row['quiz2_id']).'">
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet QUIZ ?\')">Supprimer</button>
                  </form>
                </div>

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse_'.$row['quiz2_id'].'"
                  aria-expanded="false" aria-controls="collapseExample">
                  <i class="fas fa-sort-down fa-2x"></i> Étudiants Résultats
                </button>
              </div>

              <div class="collapse" id="collapse_'.$row['quiz2_id'].'">
                <div class="card card-body">
                  <table class="table">
                    <thead>
                      <tr class="trst">
                        <th scope="col" class="center">Nom d\'etudiant</th>
                        <th scope="col" class="center">Nombre des reponses correcte</th>
                      </tr>
                    </thead>
                    <tbody>

                  

                ';

                $qr = "SELECT * from quiz_resultat2 where quiz2_id=?";

                $val = array($row['quiz2_id']);

                $stm = PDO($qr,$val);

                if ($stm->rowCount()!=0) {

                  while($row = $stm->fetch()){

                                $id_etd2 = $row['student_id'];

                                $q2 = "SELECT name as nom_etd from student where student_id = ?";

                                $v2 = array($id_etd2);

                                $r2 = PDO($q2,$v2);

                                if ($r2->rowCount()!=0) {

                                  while($rw = $r2->fetch()){

                                    $nom_etd2 = test_input($rw['nom_etd']);

                                  }

                                }

                                $reslt3=$row['resultat'];
                                $reslt2=$reslt3-1;

                            echo '<tr>

                                  <td>'.$nom_etd2.'</td>

                                  <td>'.$reslt2.'</td>

                                  ';

                  }

                }else{

                  echo "<td>acune resultat est disponible pour le moment</td>";

                }



                

              echo '

                    </tbody>

                    </table>

                    </div>

                    </div>

              </p>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>



';

   }

  } else {

    echo "<div class='container'><div class='alert alert-info'>Aucun quiz niveau 2 pour l'instant.</div></div>";

  }



      /*traitement si c'est un proffesseur*/

    echo "</div> <br><br>";

    

?>



<?php
/***********************************************************/
/*                traitement pour QUIZ  3                  */
/***********************************************************/
echo "<div id=\"quiz3\" class=\"tabcontent\">";

$query8 = "SELECT * FROM quiz3 WHERE teacher_id = ? ORDER BY quiz3_id DESC";
$values8 = array($_SESSION['teacher_id']);
$stm8 = PDO($query8, $values8);

if ($stm8->rowCount() != 0) {
    while ($row = $stm8->fetch()) {
        echo '
        <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card text-center cardpadding">
              <div class="card-body">
                <div class="media">
                  <img src="static/img/cours espace/undraw_files1_9ool.svg" class="align-self-start mr-3 pdfsize" alt="pdf png image">
                  <div class="media-body"> 
                    <div class="d-flex flex-column" style="width: fit-content; margin: 0 auto;">
                      <h4 class="mt-0">Quiz : '.test_input($row['nom_quiz']).'</h4>
                      <div class="d-flex justify-content-center gap-2 mb-3">
                        <form method="post" action="quiz_teacher3.php" class="mx-1">
                          <input type="hidden" name="id" value="'.test_input($row['quiz3_id']).'">
                          <button type="submit" class="btn btn-outline-primary">Consulter</button>
                        </form>
                        <form method="post" action="traitement/dropquiz3.php" class="mx-1">
                          <input type="hidden" name="id" value="'.test_input($row['quiz3_id']).'">
                          <button type="submit" class="btn btn-outline-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet QUIZ ?\')">Supprimer</button>
                        </form>
                      </div>
                      <div class="text-center mt-2">
                        <form method="post" action="note_quiz3.php">
                          <input type="hidden" name="quiz3_id" value="'.test_input($row['quiz3_id']).'">
                          <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-check-circle"></i> Évaluer
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>';
    }
} else {
    echo "<div class='container'><div class='alert alert-info'>Aucun quiz niveau 3 pour l'instant.</div></div>";
}

echo "</div>";
?>

  



  <!--Fotter,script and Contact form-->

  </section>

    <?php

    include("traitement/footer.php");

    ?> 

    <!-- <style type="text/css">

                  /* .tab {

                  overflow: hidden;

                  background-color: #222831;

                  color: white;

                  text-decoration: none;

                  }

                /* Style the buttons inside the tab */

                .tab button {

                  background-color: inherit;

                  float: left;

                  border: none;

                  outline: none;

                  cursor: pointer;

                  padding: 5px 16px;

                  transition: 0.3s;

                  font-size: 20px;

                  text-align: center;

                  color: white;

                  text-decoration: none;

                }

                

                /* Change background color of buttons on hover */

                .tab button:hover {

                  background-color: #57585a;

                  color: white;

                  text-decoration: none;

                }



                /* Create an active/current tablink class */

                .tab button.active {

                  background-color: #57585a;

                  color: white;

                  text-decoration: none;

                }

                .tab button:focus{

                  background-color: #57585a;

                  color: white;

                  text-decoration: none;

                } 

    </style> -->

    <!-- <script>

            // var acc = document.getElementsByClassName("accordion");

            // var i;



            // for (i = 0; i < acc.length; i++) {

            //   acc[i].addEventListener("click", function() {

            //     this.classList.toggle("active");

            //     var panel = this.nextElementSibling;

            //     if (panel.style.display === "block") {

            //       panel.style.display = "none";

            //     } else {

            //       panel.style.display = "block";

            //     }

            //   });

            // }

    </script>

    <script>

              // function openCity(evt, cityName) {

              //   var i, tabcontent, tablinks;

              //   tabcontent = document.getElementsByClassName("tabcontent");

              //   for (i = 0; i < tabcontent.length; i++) {

              //     tabcontent[i].style.display = "none";

              //   }

              //   tablinks = document.getElementsByClassName("tablinks");

              //   for (i = 0; i < tablinks.length; i++) {

              //     tablinks[i].className = tablinks[i].className.replace(" active", "");

              //   }

              //   document.getElementById(cityName).style.display = "block";

              //   evt.currentTarget.className += " active";

              // }

              // // Get the element with id="defaultOpen" and click on it

              // document.getElementById("defaultOpen").click();

    </script> -->
    <script src="static/js/cours-espace.js"></script>

</body>

</html>