<?php

include('traitement/function.php');

$id = $_GET['id'];





$query2 = "SELECT * FROM demande_student where id=? ;";
$values2= array($id);
$result2 = PDO($query2,$values2);

if ($result2->rowCount()!=0) {
    while($row = $result2->fetch())
    {

        $query3 = 'INSERT INTO student(name,email,password,date_of_birth) 
                  values(?,?,?,?);';

        $values3 = array($row['name'],$row['email'],$row['password'],$row['date_of_birth']);


        $result3 = PDO($query3,$values3);
        if ($result3) {
            $query4 ='DELETE FROM demande_student WHERE id =?;';
            $values4= array($id);
            $result4 = PDO($query4,$values4);

            header("location: index.php");

        }else{
            echo $row['type_user']." erreur dans le traitement! ";
        }
    }
}

?>