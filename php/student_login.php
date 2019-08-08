<?php
/*Efarmer vijai htdocs*/


session_start();
//require 'db_config.php' ;

?>

<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$phone=$_GET['phone'];
//$mail=$_GET['mail'];
$output=array();


	
	if(isset($_GET['phone']))
	{
        //or mail='$mail'
        $res=mysqli_query($conn,"SELECT * from student_details where phone='$phone' ");
        //$row=mysqli_fetch_assoc($res)
        $rows=mysqli_num_rows($res);
        if($rows<=0){
            $output['error']=true;
    		$output['message']="incorrect phone";
        }
        else{
                    $for_id_name=mysqli_query($conn,"SELECT * from student_details where phone='$phone'");
    				$rows=mysqli_fetch_assoc($for_id_name);
					
					//$_SESSION['phone']=$row['phone'];
					//$_SESSION['username']=$rows['name'];
					//$_SESSION['id']=$rows['id'];
					
				
					$output['error']=false;
					$output['message']="login success";
					$output['reg_no']=$rows['reg_no'];
					$output['username']=$rows['name'];
        }
        
    
        
	}	
	else
	{
		
		$output['message']="fill required";
	}
echo json_encode($output);	

mysqli_close($conn);
?>



