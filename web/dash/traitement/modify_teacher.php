<?php

/*Ajouter la connexion a lbase de donnes*/
include("function.php");

$_POST['teacher_id']=$_GET['id'];


  if (isset($_POST['teacher_id']) AND isset($_POST['name']) AND isset($_POST['date_of_birth']) AND
    isset($_POST['email']) AND isset($_POST['password']) ) {
	if (!(empty($_POST['teacher_id'])) AND !(empty($_POST['name'])) AND !(empty($_POST['date_of_birth'])) 
        AND !(empty($_POST['email'])) AND !(empty($_POST['password'])) ) {
            // Hash du mot de passe avant la mise à jour
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $query = 'UPDATE teacher
              		set name=?,
              		date_of_birth=?,
              		email=?,
                    password=?
              		WHERE teacher_id=? ;';
            $value = array($_POST['name'],$_POST['date_of_birth'],$_POST['email'],$hashed_password,$_POST['teacher_id']);			
			$result = PDO($query,$value);
			
			
		
			if($result->rowCount()!=0) {
			
				
				echo '<script language="Javascript"> document.location.replace("../teacher.php?etat=true"); </script>';
				
			}
			else{
				
					echo '<script language="Javascript"> document.location.replace("../teacher.php?etat=false"); </script>';
					
					
			}
    }
    else{
    	echo "Un champ est vide";
    }

  }
  else{
	
		echo '<script language="Javascript"> document.location.replace("../teacher.php?etat=false"); </script>';
		
        
  }
?>