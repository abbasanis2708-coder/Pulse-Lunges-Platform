<?php



/*Ajouter la connexion a lbase de donnes*/



include("function.php");


$_POST['student_id']=$_POST['id'];





  if (isset($_POST['name']) AND isset($_POST['date_of_birth'])  AND isset($_POST['email'])) {



              if (!(empty($_POST['name'])) AND !(empty($_POST['date_of_birth']))  AND !(empty($_POST['email']))) {

              if(isset($_POST['pass1'])){
                    if((!(empty($_POST['pass1'])) )){
                        
                      	     // Hash du nouveau mot de passe
                      	     $hashed_password = password_hash(test_input($_POST['pass1']), PASSWORD_DEFAULT);
                      	     
                      	     $query1 = 'UPDATE student
                      				set name=?,
                      				email=?,
                      				date_of_birth=?,
                      				password=?
                      				WHERE student_id=? ;';

                              $values1 = array(test_input($_POST['name']),test_input($_POST['email']),$_POST['date_of_birth'],$hashed_password
                                          ,$_POST['student_id']);

              				}else{

                              $query1 = 'UPDATE student

                              set name=?,

                                email=?,

                                date_of_birth=?

                                WHERE student_id=? ;';

                              $values1 = array(test_input($_POST['name']),test_input($_POST['email']),$_POST['date_of_birth'],$_POST['student_id']);

                      }

              				

                      $result = PDO($query1,$values1);

					

					if($result) {

		           echo '<script language="Javascript"> document.location.replace("../profile_student.php?etat=true"); </script>';
          }else{

              echo '<script language="Javascript"> document.location.replace("../profile_student.php?etat=false"); </script>';
          }

	}



	else{
      echo '<script language="Javascript"> document.location.replace("../profile_student.php?etat=false"); </script>';
	}



              }

          



            }

        else{

        	header("location: ../profile_student.php");

        }

?>