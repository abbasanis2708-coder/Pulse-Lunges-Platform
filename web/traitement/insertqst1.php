<?php

/*insertion du quiz a la base de donnes*/

session_start();

include("function.php");



$query1 = "SELECT quiz1_id from quiz1 order by quiz1_id desc limit 1;";
$value1 = array();

$stm1 = PDO($query1,$value1);
if ($stm1 === false) {
	// If there was an error executing the query
	$id_quiz = 1;
} else {
	$row1 = $stm1->fetch(PDO::FETCH_ASSOC);
	if (!$row1) {
		// If the query returned an empty result set
		$id_quiz = 1;
	} else {
		$id_quiz = $row1['quiz1_id'] + 1;
	}
}



if(!isset($_POST['qst'])){

	
}




for ($i=1; $i <=$_POST['qst'] ; $i++) { 

	

if (isset ($_POST['titre']) && isset($_POST['question'.$i]) && isset($_POST['option_1'.$i]) && isset($_POST['option_2'.$i])
 && isset($_POST['option_3'.$i]) && isset($_POST['option_4'.$i])&& isset($_POST['cas_clinique'.$i])&&isset($_POST['audio_file'.$i])) {

	

	if ( empty($_POST['titre']) || empty($_POST['question'.$i]) || empty($_POST['option_1'.$i]) || empty($_POST['option_2'.$i]) 
    || empty($_POST['option_3'.$i])|| empty($_POST['option_4'.$i])|| empty($_POST['cas_clinique'.$i])|| empty($_POST['audio_file'.$i])) {



			echo "remplisser tous les champs !";



    }else{

        	$query3 = "INSERT into quiz1(quiz1_id,nom_quiz,teacher_id) values(?,?,?)";

			$values3 = array($id_quiz,test_input($_POST['titre']),$_SESSION['teacher_id']);



			

			$result=PDO($query3,$values3);

			/***********************/

			// if ($result) {

			// 	echo '<script language="Javascript"> document.location.replace("../addquiz1.php?etat=true1"); </script>';

		    // }else{

		

			// echo '<script language="Javascript"> document.location.replace("../addquiz1.php?etat=qst_quiz_1 no insert"); </script>';

		

			// }


			/*insertion des question*/

        	$query4 = "INSERT INTO qst_quiz_1(quiz1_id,n_question,question_text,option_1,option_2,option_3,option_4,audio_file,cas_clinique)
             values(?,?,?,?,?,?,?,?,?) ";

        	$values4 = array($id_quiz,$i,test_input($_POST['question'.$i]),test_input($_POST['option_1'.$i]),
        				test_input($_POST['option_2'.$i]),test_input($_POST['option_3'.$i]),test_input($_POST['option_4'.$i])
                        ,test_input($_POST['audio_file'.$i]),test_input($_POST['cas_clinique'.$i]));

            $result4=PDO($query4,$values4);
            if ($result4) {

				echo '<script language="Javascript"> document.location.replace("../addquiz1.php?etat=true"); </script>';

		    }else{

		

			echo '<script language="Javascript"> document.location.replace("../addquiz1.php?etat=qst_quiz_1 no insert"); </script>';
            }


			/**********************/

    }





}else {

		echo '<script language="Javascript"> document.location.replace("../addquiz1.php?etat=false"); </script>';

	}







}			


		

			
		





?>