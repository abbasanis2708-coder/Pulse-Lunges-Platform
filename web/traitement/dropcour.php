<?php
include("function.php");
if (isset($_POST['id'])) {
    echo $_POST['id'];
    $query1 = "DELETE FROM cours where cours_id= ?";
    $query2 = "DELETE FROM cours_audio where cours_id = ?";
    $values = array($_POST['id']);
    PDO($query1, $values);
    PDO($query2, $values);
    echo '<script> document.location.replace("../index_teacher.php?etat=true"); </script>';
} else {
    echo '<script > document.location.replace("../index_teacher.php?etat=false"); </script>';
}
?>