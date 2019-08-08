<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$reg_no=$_GET['reg_no'];
$reset_candidate=$_GET['reset_candidate'];
$reset_student=$_GET['reset_student'];
$post=$_GET['post'];
$reset_dept=$_GET['reset_dept'];

$output=array();
$rstu;//reset student vote as 0
$rcan;//clear the candidate list 

if(!strcmp($post,"secretary")){
	$rcan=1;
	$rstu=1;
}
elseif(!strcmp($post,"chairman")){
	$rstu=0;
	$rcan=0;
}


if(isset($_GET['reg_no'])){
$get_detail=mysqli_query($conn,"SELECT  * from admin_details where reg_no='$reg_no'");
$row=mysqli_fetch_array($get_detail);
$dept=$row['dept'];
//reset 3rd yr student vote as 0	
if($reset_student==1 && $rstu==1)
{
       
		if($get_detail){
			$set_voted_student=mysqli_query($conn,"UPDATE student_details SET vote='0' WHERE vote='1' and dept='$dept' and batch=2020");
			if($set_voted_student){
				$output['message']="$dept 3rd yr student reseted!!";
				$output['error']=false;
			}
			else{
			$output['message']="$dept 3rd yr student cannot reset!!";
			$output['error']=true;
				
			}
		}
	    
        
}
//reset 4th yr student vote as 0
if( $reset_student==1 && $rstu==0)
{
       
		if($get_detail){
			$set_voted_student=mysqli_query($conn,"UPDATE student_details SET vote='0' WHERE vote='1' and dept='$dept' and batch=2019");
			if($set_voted_student){
				$output['message']="$dept 4th yr student reseted!!";
				$output['error']=false;
			}
			else{
			$output['message']="$dept 4rd yr student cannot reset!!";
			$output['error']=true;
				
			}
		}
	    
        
}
//delete secretary candidate list
if($reset_candidate==1 && $rcan==1 )
{
      
		if($get_detail){
			$clear_secretary=mysqli_query($conn,"TRUNCATE secretary_candidates");
			if($clear_secretary){
				$output['message']="$dept secretary_candidates list cleared!!";
				$output['error']=false;
			}
			
			else{
			$output['message']="$dept secretary cannot reset!!";
			$output['error']=true;
				
			}
		}
	    
        
}
//delete chairman candidate list
if($reset_candidate==1 && $rcan==0 )
{
  
		if($get_detail){
			$clear_chairman=mysqli_query($conn,"TRUNCATE chairman_candidates");
			if($clear_chairman){
				$output['message']="$dept chairman_candidates list cleared!";
				$output['error']=false;
			}
			else{
			$output['message']="$dept chairman cannot reset!!";
			$output['error']=true;
				
			}
		}
	    
        
}
if($reset_dept==1 )
{
		
		if($get_detail){
			
			$clear_dept=mysqli_query($conn,"DELETE FROM vote_timers WHERE dept='$dept'");
			if($clear_dept){
				
				$output['message']="$dept department vote timer cleared!!";
				$output['error']=false;
			}
			else{
			$output['message']="$dept timer cannot reset!!";
			$output['error']=true;
				
			}
		}
	    
        
}


}
else
{
		
	$output['message']="fill required";
	$output['error']=true;
}
echo json_encode($output);	

mysqli_close($conn);
?>



