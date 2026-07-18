<?php
include("traitement/singup_student.php");
	
?>

<!DOCTYPE html>

<html>

<head>

	<title>Demande étudiant</title>

	<link rel="stylesheet" type="text/css" href="static/css/sign-up.css">

	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">

	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">

</head>

<body>

	<div class="container">

		<div class="contact-box">

			<div class="left"></div>

			<div class="right">

				<h2>Demande étudiant</h2>

			<form method="POST" action="#">

			<!--<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">-->

				<input type="text" name="name" class="field" placeholder="Nom" >

				<input type="text" name="email" class="field" placeholder="Email" >

				<input type="date" name="date_of_birth" class="field" placeholder="Date Naissance" >

				<input type="password" name="password" class="field" placeholder="Mot de passe" >

				<input type="submit" name="submit" class="btn btn-danger">
				<a class="lienindex" href="index.php">Page d'acceuil</a>
				<?php if(!empty($message)) : ?>

                  <p><?php echo $message; ?></p>



                  <?php  endif; ?>

			</form>

			</div>

		</div>

	</div>

	<!--Traitement d ajoute-->



</body>

</html>