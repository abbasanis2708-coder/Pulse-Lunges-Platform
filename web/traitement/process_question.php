<?php
session_start();
include("function.php");

$question = strtolower(trim($_POST['question']));
$quiz_id = $_POST['quiz_id'];

$query = "SELECT * FROM qst_quiz_3 WHERE quiz_id = ?";
$questions = PDO($query, [$quiz_id])->fetchAll();

$reponse = "Je ne suis pas sûr de comprendre votre question.";

foreach ($questions as $q) {
    if (str_contains($question, strtolower($q['mot_cle']))) {
        $reponse = $q['reponse'];
        break;
    }
}

if (!isset($_SESSION['reponses'])) {
    $_SESSION['reponses'] = [];
}
$_SESSION['reponses'][] = $reponse;

header("Location: ../quiz_student3.php");
exit();
