<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = $_SERVER['REQUEST_URI'];
$tab = explode("/", $url);
$act = [];
$title = "accueil"; // Default value to prevent 'Undefined variable' warning

switch ($tab[count($tab) - 1]) {
    case 'index.php':    
        $act['index.php'] = 'active'; 
        $title = 'index';
        break;
    case 'index_student.php':    
        $act['index_student.php'] = 'active'; 
        $title = 'Acceuil';
        break;
    case 'profile_student.php':    
        $act['profile_student.php'] = 'active'; 
        $title = 'Profile';
        break;
    case 'quiz_espace_teacher.php':    
        $act['quiz_espace_teacher.php'] = 'active'; 
        $title = 'Evaluation';
        break;
    case 'quiz_espace_student.php':    
        $act['quiz_espace_student.php'] = 'active'; 
        $title = 'Evaluation';
        break;
    case 'modifier_student.php':    
        $act['modifier_student.php'] = 'active'; 
        $title = 'Profile';
        break;
    default:
        $title = 'Accueil'; // Ensures $title is never undefined
        break;
}
?>

<!-- Nav BAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.php">
        <img src="static/img/logo.png" width="45" height="45" class="d-inline-block align-top" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo $act['index_student.php'] ?? ''; ?>" href="index_student.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $act['quiz_espace_student.php'] ?? ''; ?>" href="quiz_espace_student.php">Evaluation</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <?php if (!isset($_SESSION['student_id'])) { ?>
                <button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href='login.php'">Sign-in</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-outline-success btnmarging" onclick="window.location.href='sign-up.php'">Sign-up</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } else { ?>
                <a class="alien" href="profile_student.php"><i class="fas fa-user-graduate"></i> Profile</a>&nbsp;&nbsp;
                <a class="btn btn-outline-danger" href="traitement/deconnexion_student.php">Deconnexion</a>
            <?php } ?>
        </form>
    </div>
</nav>

<?php 
if ($title != "index") {
    echo '<div>
        <section class="sectionpath"><br><br><br><br><p><b><i class="fas fa-home"></i>&nbsp;Acceuil/</b></p></section>
    </div>';
}
?>
