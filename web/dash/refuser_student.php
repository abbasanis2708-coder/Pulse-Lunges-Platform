<?php

include('traitement/function.php');

$id = $_GET['id'];

$query1=" DELETE FROM demande_student WHERE id =?;";
$value = array($id);

$result1= PDO($query1,$value);

if ($result1) {
  header("location: index.php");
}else{
  echo "erreur est produit";
}


?>