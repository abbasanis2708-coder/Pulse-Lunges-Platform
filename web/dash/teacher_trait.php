<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ajouter Professeur</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link href="css/style.css" rel="stylesheet">

</head>



  <body id="page-top">

 <?php
 /*Ajouter le Dashboard*/
include("dashboard.php");
/*Ajouter la connexion a lbase de donnes*/
include("traitement/function.php");

if(isset($_GET['id'])){
$id = $_GET['id'];

$sql = "SELECT * FROM `teacher` WHERE teacher_id=? ";
$value = array($id);

$result = PDO($sql,$value);

    if($result->rowCount()!=0)  {
            while($row = $result->fetch())
                {
                  
                  $name = $row['name'] ;
                  $date_of_birth = $row['date_of_birth'] ;
                  $email= $row['email'] ;
                  $password = $row['password'] ;
                  
                }

            
    }


}
 ?>
<!--*************************************************************************************-->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus"></i> Professeurs</h6>
            <?php
      if (isset($_GET['etat'])) {
        if($_GET['etat']=="true"){
          echo '
            <div class="alert alert-success">
              <i class="far fa-check-square"></i> L\'opération s\'effectue avec <strong>Success!</strong>
            </div>
            <script>
               setTimeout(function(){
                  window.location.href = \'teacher.php\';
               }, 2000);
            </script>
            ';
          }else if($_GET['etat']=="duplicate"){
            echo '
              <div class="alert alert-danger">
                <i class="fas fa-times"></i> Utilisateur déja  <strong>existant!</strong>
              </div>
              <script>
                 setTimeout(function(){
                    window.location.href = \'teacher_trait.php\';
                 }, 2000);
              </script>
              ';
            }else{
            echo '<div class="alert alert-danger">
                      <i class="fas fa-times"></i> <strong>Error !<strong> l\'hors de l\'opération ! .
                  </div>
                  <script>
                     setTimeout(function(){
                        window.location.href = \'teacher.php\';
                     }, 2000);
                  </script>
                  ';

          }
      }
?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- <style>
                  #datatable {
                  text-align: center;
                  font-size: 17px;
                  font-family: monospace;
                }
                sup{
                   color: red;
                }
                </style> -->
                <?php 
                  if(isset($_GET['id'])){
                    echo '<form action="traitement/modify_teacher.php?id='.$id.'" method="POST" id="formajout">';
                  }else{
                    echo '<form action="traitement/add_teacher.php" method="POST" id="formajout">';
                  }
                ?>
                
                <p class="sup2"><i class="fas fa-exclamation-triangle"></i> Touts les champs est obligatoires</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Code Professeur</span>
                  </div>
                  <input type="number" name="code_massar" class="form-control" required="required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php if(isset($_GET['id'])){ echo 'value="'.$id.'"'; }
                  else{ echo 'placeholder="Auto" '; }?> disabled>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
                  </div>
                  <input type="text" name="name" class="form-control" required="required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php if(isset($_GET['id'])){ echo 'value="'.$name.'"'; }?>>
                </div>
             
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Date de naissance</span>
                  </div>
                  <input type="date" name="date_of_birth" class="form-control" required="required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php if(isset($_GET['id'])){ echo 'value="'.$date_of_birth.'"'; }?>>
                </div>
                
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                  </div>
                  <input type="email" name="email" placeholder="exemple@domain.com" class="form-control" required="required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php if(isset($_GET['id'])){ echo 'value="'.$email.'"'; }?>>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Mot de passe</span>
                  </div>
                  <input type="text" name="password" class="form-control" required="required" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php if(isset($_GET['id'])){ echo 'value="'.$password.'"'; }?>>
                </div>
                <input type="submit" name="submit" class="btn btn-info float-right">
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Pulse Lungs Apprentissage-<?php echo Date('Y');?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>


</body>
</html>