<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$reg_no=$_GET['reg_no'];
$can_status=$_GET['can_status'];
$stu_status=$_GET['stu_status'];
$post=$_GET['post'];
$output=array();
$gpost;

if(!strcmp($post,"secretary")){
	$gpost=1;
}
elseif(!strcmp($post,"chairman")){
	$gpost=0;
}


$get_detail=mysqli_query($conn,"SELECT  dept from admin_details where reg_no='$reg_no'"); 
$admin_row=mysqli_fetch_assoc($get_detail);
$dept=$admin_row['dept'];

//get secretary status	
if(isset($_GET['reg_no'])&& isset($_GET['can_status']) && !strcmp($post,"secretary"))
{	
	
       
		if($can_status==1){
			
			$status=mysqli_query($conn,"SELECT  reg_no,name,vote_count from secretary_candidates WHERE dept='$dept' ORDER BY vote_count desc"); 
			if($status){
				if(mysqli_num_rows($status)>0){
					while($row[]=mysqli_fetch_assoc($status)){
						$output=$row;
							
					}
				}
			}
			else{$output['message']="$dept secretary candidate list no available, list may be erased";}
		}
        
}
//get chairman status
elseif(isset($_GET['reg_no'])&& isset($_GET['can_status']) && !strcmp($post,"chairman"))
{
		if($can_status==1){
			
			$status=mysqli_query($conn,"SELECT  reg_no,name,vote_count from chairman_candidates WHERE dept='$dept' ORDER BY vote_count desc"); 
			if($status){
				if(mysqli_num_rows($status)>0){
					while($row[]=mysqli_fetch_assoc($status)){
						$output=$row;	
					}
				}
			}
			else{$output['message']="$dept chairman candidate list no available, list may be erased";}
		}
        
}
//student status 3rd yr
elseif( isset($_GET['reg_no'])&& isset($_GET['stu_status']) && !strcmp($post,"secretary")){
	$status=mysqli_query($conn,"SELECT  section,count(reg_no) from student_details WHERE dept= '$dept',batch='2020' and vote='1' GROUP BY section"); 
	if($status){
		if(mysqli_num_rows($status)>0){
			while($row[]=mysqli_fetch_assoc($status)){
				$output=$row;					
			}
		}	
	}		
	else{$output['message']="$dept voter list not avalible, list may be reseted!!";}
	
}
//student status 4th yr
elseif(isset($_GET['reg_no'])&&isset($_GET['stu_status'])&& !strcmp($post,"chairman")){
	$status=mysqli_query($conn,"SELECT  section,count(reg_no) from student_details WHERE dept= '$dept',batch='2019' and vote='1' GROUP BY section"); 
	if($status){
		if(mysqli_num_rows($status)>0){
			while($row[]=mysqli_fetch_assoc($status)){
				$output=$row;					
			}
		}	
	}		
	else{$output['message']="$dept voter list not avalible, list may be erased!!";}
	
}		
else
{
		
	$output['message']="fill required";
}
echo json_encode($output);	

mysqli_close($conn);
?>



