<?php
  $url = $_SERVER['REQUEST_URI'];
  $tab = explode("/", $url);

  $act = array(
      'index.php'=>'',
      'index_teacher.php'=>'', // Added this line
      'filiere-1.php'=>'',
      'cours-espace.php'=>'',
      'biblio.php'=>'',
      'contact-us.php'=>'',
      'chose_lvl_quiz.php'=>'',
      'addquiz1.php'=>'',
      'profile_teacher.php'=>'',
      'quiz_espace_teacher.php'=>''
  );

  $title = "";

  switch($tab[count($tab)-1]) {
      case 'index.php': 
          $act['index.php'] = 'active'; 
          $title = 'index'; 
          break;
      case 'index_teacher.php': 
          $act['index_teacher.php'] = 'active'; 
          $title = 'Acceuil'; 
          break;
      case 'chose_lvl_quiz.php': 
          $act['chose_lvl_quiz.php'] = 'active'; 
          $title = 'Sélection du niveau quiz'; 
          break;
      case 'addquiz1.php': 
          $act['addquiz1.php'] = 'active'; 
          $title = 'Ajouter quiz'; 
          break;
      case 'profile_teacher.php': 
          $act['profile_teacher.php'] = 'active'; 
          $title = 'Profile'; 
          break;
      case 'quiz_espace_teacher.php': 
          $act['quiz_espace_teacher.php'] = 'active'; 
          $title = 'Evaluation'; 
          break;
  }
?>

<!-- Nav BAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.php">
        <img src="static/img/logo.png" width="45" height="45" class="d-inline-block align-top" alt="">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo $act['index_teacher.php']; ?>" href="index_teacher.php">Accueil
                <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $act['quiz_espace_teacher.php']; ?>" href="quiz_espace_teacher.php">Evaluation</a>
            </li>
        </ul>

        <form class="form-inline my-2 my-lg-0">
            <?php
            if (!(isset($_SESSION['teacher_id']))) {
                echo '<button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href = \'login.php\'">Sign-in</button>&nbsp;&nbsp;';
                echo '<button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href = \'sing-up.php\'">Sign-up</button>&nbsp;&nbsp;';
            } else {
                echo '
                <a class="alien" href="profile_teacher.php"><i class="fas fa-user-graduate"></i> Profile</a>&nbsp;&nbsp;
                <a class="btn btn-outline-danger" href="traitement/deconnexion_teacher.php">Deconnexion</a>';
            }
            ?>
        </form>
    </div>
</nav>

<?php 
if ($title != "index") {
    echo '<div>
        <section style="background-color:#00A67E;height:180px;padding-top:40px;">
            <br><br><br><br>
            <p><b><i class="fas fa-home"></i>&nbsp;Acceuil/' . $title . '</b></p>
        </section>
    </div>';
}
?>
