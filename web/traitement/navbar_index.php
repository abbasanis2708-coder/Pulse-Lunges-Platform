

  



 <!-- Nav BAR -->

  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">

  <a class="navbar-brand" href="index.php"><img src="static/img/logo.png" width="45" height="45" class="d-inline-block align-top" alt=""></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">

        <li class="nav-item ">

          <a class="nav-link <?php echo $act['index.php']; ?>" href="index.php"><span class="sr-only"></span></a>

        </li>

        

        <li class="nav-item">

          <a class="nav-link <?php echo $act['login_student.php']; ?>" href="login.php"></a>

        </li>

      </ul>

      <form class="form-inline my-2 my-lg-0">

<?php


  echo '<button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href = \'login_student.php \'">Connexion Etudiant </button>&nbsp&nbsp&nbsp&nbsp';

  echo '<button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href = \'sing_up_student.php \'">Inscription Etudiant</button>&nbsp&nbsp&nbsp&nbsp';
  echo '<button type="button" class="btn btn-outline-warning btnmarging" onclick="window.location.href = \'login_teacher.php \'">Connexion Professeur</button>&nbsp&nbsp&nbsp&nbsp';
  echo '<button type="button" class="btn btn-outline-danger btnmarging" onclick="window.location.href = \'login_admin.php \'">Connexion admin</button>&nbsp&nbsp&nbsp&nbsp';




  



?>       

      </form>

    </div>

    

  </nav>

  
