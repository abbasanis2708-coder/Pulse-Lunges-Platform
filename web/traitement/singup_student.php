<?php

  /*****************************************

  *  Constantes et variables

  *****************************************/

session_start(); 

 $message = '';



include("function.php");



  /*****************************************

  *  Vérification du formulaire

  *****************************************/

  // Si le tableau $_POST existe alors le formulaire a été envoyé

  if(!empty($_POST))

  {
      

      
    // Le login est-il rempli ?

    if(empty($_POST['name']))

    {

      $message = 'Veuillez indiquer votre nom ';

    }

    elseif(empty($_POST['email']))

    {

      $message = 'Veuillez indiquer votre email';

    }

    elseif(empty($_POST['date_of_birth']))

    {

      $message = 'Veuillez indiquer votre date de naissance';

    }
   
    elseif(empty($_POST['password']))

    {

      $message = 'Veuillez indiquer votre mot de passe';

    }
    
    

    
  

  elseif((!empty($_POST['name'])) AND (!empty($_POST['email'])) AND (!empty($_POST['date_of_birth'])) AND (!empty($_POST['password']))  ) 

  {

            /*traitement pour ajout a la base*/

              
    $_POST['name']= test_input( $_POST['name']);
    $_POST['email']= test_input( $_POST['email']);
    $_POST['password']= test_input($_POST['password'] );
    $_POST['date_of_birth']= test_input($_POST['date_of_birth'] );



    if (check_existe_email_student($_POST['email'])!=1 ) {
      

        if (check_existe_email_student($_POST['email'])!=1) {
          $message = 'Email deja exist ! ';
        }

    }else{

      if(test_email($_POST['email'])==1){
            $query1 = 'INSERT INTO demande_student(name,email,date_of_birth,password) values(?,?,?,?)';

            // Hash du mot de passe avant insertion
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $values1 = array($_POST['name'],$_POST['email'],$_POST['date_of_birth'],$hashed_password);

            $stm = PDO($query1,$values1);


            if ($stm) {

              $message = 'demande envoyé ! ';

              

            }else{

              $message = 'demande non envoyé ! ';

            }

      }else{

        $message = 'Format de l\'email est invalide';
      }
                    
    

  }

  

  }  
  else
  {

    $message = "Enter votre coordonnées  ";

  }       

}

?>