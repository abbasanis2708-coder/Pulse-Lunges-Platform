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

    <link rel="stylesheet" href="static/css/profile.css">

    <link rel="stylesheet" href="static/css/index.css">

    <title>Sélection du niveau quiz</title>

</head>

<body>
<?php

include("traitement/navbar_teacher.php");

include("traitement/function.php");


 ?>


        

          

            <div style="margin: auto;
  width: 50%;
  padding: 8px;" >

                <div style="text-shadow: 2px 4px 3px rgba(0,0,0,0.3);font-weight:Bold;font-size: 2em;" >

                Choisissez le niveau du quiz:

                </div><br>
                
                                <div style="margin: auto;
  width: 50%;
  padding: 10px;">
                                  <?php  

                                    

                                      echo '<a href="addquiz1.php" class="btn btn-info">Quiz du niveau 1 </a><br><br>';

                                      echo '<a href="addquiz2.php" class="btn btn-info">Quiz du niveau 2</a><br><br>';
echo '<a href="addquiz3.php" class="btn btn-info">Quiz du niveau 3</a><br><br>';



                                  ?>
                                </div>

                                  
                </div>

            

        
        
<?php

include("traitement/footer.php");

?>  

<!-- End Footer -->

    <!-- End Posts Section -->

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script src="static/js/bootstrap.js"></script>

</body>

</html>