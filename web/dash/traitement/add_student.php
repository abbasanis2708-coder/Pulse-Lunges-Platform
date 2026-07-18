<?php
/*Ajouter la connexion a lbase de donnes*/
include("function.php");

if (isset($_POST['name']) && isset($_POST['date_of_birth']) && isset($_POST['email']) && isset($_POST['password'])) {
	$name = $_POST['name'];
	$date_of_birth = $_POST['date_of_birth'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Vérifier si l'email et le nom existent déjà
	$query = "SELECT * FROM student WHERE email = ?";
	$value = array($email);
	$result = PDO($query, $value);
	if ($result->rowCount() > 0) {
		header("location: ../student_trait.php?etat=duplicate");
	}else{

			// Insérer l'enregistrement dans la base de données
			$query = "INSERT INTO student(name, date_of_birth, email, password) VALUES (?, ?, ?, ?)";
			
			// Hash du mot de passe avant insertion
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			
			$value = array($name, $date_of_birth, $email, $hashed_password);
			$result = PDO($query, $value);

			if ($result) {
				header("location: ../student_trait.php?etat=true");
			} else {
				header("location: ../student_trait.php?etat=false");
			}
		}
} else {
	header("location: ../student_trait.php?etat=false1");
	exit();
}
?>