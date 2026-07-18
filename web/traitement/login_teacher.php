<?php

  /*****************************************

  *  Constantes et variables

  *****************************************/

session_start(); 

 $message = '';



include("function.php");





$LOGIN = '';

$PASSWORD = '';



  /*****************************************

  *  Vérification du formulaire

  *****************************************/

  // Si le tableau $_POST existe alors le formulaire a été envoyé

  if(!empty($_POST))

  {

    // Le login est-il rempli ?

    if(empty($_POST['login']))

    {

      $message = 'Veuillez indiquer votre login svp !';

    }

      // Le mot de passe est-il rempli ?

    elseif(empty($_POST['password']))

    {

      $message = 'Veuillez indiquer votre mot de passe svp !';

    }

  

  elseif((!empty($_POST['login'])) AND (!empty($_POST['password']))) 

  {

            /*traitement pour le login*/

          

                
                // D'abord, on essaie de récupérer l'enseignant par email
                $query1 = "SELECT teacher_id, name, password from teacher where email=?";
                $values1 = array($_POST['login']);   
                $result = PDO($query1,$values1);

                if($result->rowCount()!=0){
                    $row = $result->fetch();
                    
                    // On vérifie si le mot de passe est déjà hashé (commence par $)
                    if(str_starts_with($row['password'], '$')) {
                        // Si oui, on vérifie avec password_verify
                        if(password_verify($_POST['password'], $row['password'])) {
                            $_SESSION['email'] =  test_input($_POST['login']);
                            $_SESSION['teacher_id'] = $row['teacher_id'];
                            $_SESSION['nom'] = test_input($row['name']);
                            header("Location: profile_teacher.php");
                        } else {
                            $message = 'Votre mot de passe ou username incorrect';
                        }
                    } else {
                        // Si non, on vérifie avec le mot de passe en clair
                        if($_POST['password'] === $row['password']) {
                            // Si correct, on hashe le mot de passe et on le met à jour
                            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $update_query = "UPDATE teacher SET password = ? WHERE teacher_id = ?";
                            PDO($update_query, [$hashed_password, $row['teacher_id']]);
                            
                            $_SESSION['email'] =  test_input($_POST['login']);
                            $_SESSION['teacher_id'] = $row['teacher_id'];
                            $_SESSION['nom'] = test_input($row['name']);
                            header("Location: profile_teacher.php");
                        } else {
                            $message = 'Votre mot de passe ou username incorrect';
                        }
                    }
                }
                else
                {
                    $message = 'Votre mot de passe ou username incorrect';
                }
          









    

}

else

{

  $message = "Enter votre cordonaie ";

}

}         



?>