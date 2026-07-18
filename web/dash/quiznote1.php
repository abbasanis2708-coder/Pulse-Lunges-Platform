<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['nom'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Note quiz niveau 1</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="css/custom-datatables.css" rel="stylesheet">

  <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

 <?php
 /*Ajouter le Dashboard*/
include("dashboard.php");
/*Ajouter la connexion a lbase de donnes*/
include("traitement/function.php");

 ?>
<!--*************************************************************************************-->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Résultats Quiz Niveau 1</h6>
<?php
      if (isset($_GET['etat'])) {
        if($_GET['etat']=="true"){
          echo '
            <div class="alert alert-success">
              <i class="far fa-check-square"></i> L\'opération s\'effectue avec <strong>Success!</strong>
            </div>
            <script>
               setTimeout(function(){
                  window.location.href = \'quiznote1.php\';
               }, 2000);
            </script>
            ';
          }else{
            echo '<div class="alert alert-danger">
                      <i class="fas fa-times"></i> <strong>Error !<strong> l\'hors de l\'opération ! .
                  </div>
                  <script>
                     setTimeout(function(){
                        window.location.href = \'quiznote1.php\';
                     }, 2000);
                  </script>
                  ';
          }
      }
?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Id Etudiant</th>
                      <th>Nom</th>
                      <th>Date de naissance</th>
                      <th>Id quiz</th>
                      <th>La note</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    try {
                        $qr = "SELECT qr.*, s.name, s.date_of_birth 
                              FROM quiz_resultat1 qr 
                              INNER JOIN student s ON qr.student_id = s.student_id 
                              ORDER BY s.name";
                        
                        $stm = PDO($qr, array());
                        
                        if ($stm->rowCount() != 0) {
                            while($row = $stm->fetch()) {
                                $note = $row['resultat'] - 1;
                                echo '<tr>
                                    <td>'.$row['student_id'].'</td>
                                    <td>'.test_input($row['name']).'</td>
                                    <td>'.test_input($row['date_of_birth']).'</td>
                                    <td>'.$row['quiz1_id'].'</td>
                                    <td>'.$note.'</td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">Aucun résultat trouvé</td></tr>';
                        }
                    } catch (PDOException $e) {
                        error_log("Erreur dans quiznote1.php : " . $e->getMessage());
                        echo '<tr><td colspan="5" class="text-center text-danger">Une erreur est survenue lors de la récupération des résultats</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
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
