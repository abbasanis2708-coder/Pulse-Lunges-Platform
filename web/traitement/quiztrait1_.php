<?php
session_start();

include("function.php");

$score = 0;

$q = 1;
if (!isset($_POST['id'])) {
	echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php"); </script>';
} else {
	$id_quiz = $_POST['id'];
}

$rep_correcte = ""; // Variable to store correct responses
$rep_incorrecte = ""; // Variable to store incorrect responses

$query3 = "SELECT COUNT(quiz1_id) AS nbr FROM qst_quiz_1 WHERE quiz1_id = ?";
$values3 = array($id_quiz);
$stm = PDO($query3, $values3);

if ($stm->rowCount() != 0) {
	while ($row = $stm->fetch()) {
		$nbr_qst = $row['nbr'];
	}
}

while ($q <= $nbr_qst) {
	if (isset($_POST[$q])) {
		$query = "SELECT * FROM qst_quiz_1 WHERE quiz1_id = ? AND n_question = ?";
		$value = array($id_quiz, $q);
		$res = PDO($query, $value);

		if ($res->rowCount() != 0) {
			while ($row = $res->fetch()) {
				$reponse = test_input($row['option_1']);
			}

			if ($reponse == $_POST[$q]) {
				/* Reponse correcte */
				$rep_correcte .= $q;
				$rep_correcte .= " ";
				$score++;
			} else {
				/* Reponse incorrecte */
				$rep_incorrecte .= $q;
				$rep_incorrecte .= " ";
			}
		}
	} else {
		/* Si la reponse n'est pas selectionnee, le score reste le meme */
		break;
	}

	$q++;
}

// Insertion into the database
$query2 = "INSERT INTO quiz_resultat1 VALUES (?, ?, ?, ?, ?)";
$values2 = array($id_quiz, $_SESSION['student_id'], $score, $rep_correcte, $rep_incorrecte);
$result = PDO($query2, $values2);

if ($result) {
	echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=true"); </script>';
} else {
	echo '<script language="Javascript"> document.location.replace("../quiz_espace_student.php?etat=false"); </script>';
}
?>
