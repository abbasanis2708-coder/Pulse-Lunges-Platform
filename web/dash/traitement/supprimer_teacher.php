<?php
	$sql = "DELETE FROM `teacher` WHERE teacher_id=?";
   $value = array($id);
   $result = PDO($sql,$value);
   
    if ($result) {
			if($tab[count($tab)-1]=="teacher.php"){
            
            echo '<script language="Javascript"> document.location.replace("teacher.php?etat=true"); </script>';
			}
    
}else{
      if($tab[count($tab)-1]=="etudtrait.php"){
      
      echo '<script language="Javascript"> document.location.replace("teacher.php?etat=false"); </script>';
     }
}
?>