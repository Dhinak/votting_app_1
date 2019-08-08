<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$reg_no=$_GET['reg_no'];

$output=array();


	
if(isset($_GET['reg_no']))
{
	 
		
	
			$res=mysqli_query($conn,"select * from student_details where reg_no='$reg_no'");
			$rows=mysqli_fetch_assoc($res);
			$name=$rows['name'];
			$year=$rows['batch'];
			$sdept=$rows['dept'];
			
			if($year==2020){
		
				//get secretary is set or not
				$timer_details=mysqli_query($conn,"select * from vote_timers where dept='$sdept' and secretary='1'");
				$timer_row=mysqli_fetch_assoc($timer_details);
				$start=$timer_row['start'];
				$end=$timer_row['end'];
				//if is set get the secretary_candidates details
				
				if($start==1 && $end==0){
					$get_details=mysqli_query($conn,"select reg_no,name from secretary_candidates where dept='$sdept' ORDER BY reg_no asc");
					if(mysqli_num_rows($get_details)>0){
						while($row[]=mysqli_fetch_assoc($get_details)){
							$output=$row;
							
						}
					
					}
				} 	
				else{$output['message']="$sdept polling not available";}
			}
			else if($year==2019){
				$timer_details=mysqli_query($conn,"select * from vote_timers where dept='$sdept' and chairman='1'");
				$timer_row=mysqli_fetch_assoc($timer_details);
				$start=$timer_row['start'];
				$end=$timer_row['end'];
				//if is set get the secretary_candidates details
				
				if($start==1 && $end==0){
					$get_details=mysqli_query($conn,"select reg_no,name from chairman_candidates where dept='$sdept' ORDER BY reg_no asc");
					if(mysqli_num_rows($get_details)>0){
						while($row[]=mysqli_fetch_assoc($get_details)){
							$output=$row;
							
						}
					
					}
				}
				else{$output['message']="$sdept polling not available";}
			}
			else{$output['message']="enter valid no";}
		
}		
else
{
		
	$output['message']="fill required";
}
echo json_encode($output);	

mysqli_close($conn);
?>



