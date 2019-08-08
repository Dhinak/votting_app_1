<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$reg_no=$_GET['reg_no'];
$candidate=$_GET['candidate'];
$output=array();


	
if(isset($_GET['reg_no']) && isset($_GET['candidate']))
{	
        $get_detail=mysqli_query($conn,"SELECT  * from student_details where reg_no='$reg_no'");
		$row=mysqli_fetch_assoc($get_detail);
		$year=$row['batch'];
		$voted=$row['vote'];
		$sdept=$row['dept'];
		
		
		
		if($year == 2020 && $voted==0){
			
			$timer_details=mysqli_query($conn,"select * from vote_timers where dept='$sdept' and secretary='1'");
				$timer_row=mysqli_fetch_assoc($timer_details);
				$start=$timer_row['start'];
				$end=$timer_row['end'];
				//if is set get the secretary_candidates details
				
				if($start==1 && $end==0){
					$get_vote=mysqli_query($conn,"SELECT * from secretary_candidates where reg_no='$candidate'");
					$row=mysqli_fetch_assoc($get_vote);
			
					$vote=$row['vote_count'];
					$vote=$vote+1;
					//update vote
					$update=mysqli_query($conn,"UPDATE secretary_candidates SET vote_count='$vote' WHERE reg_no='$candidate' and dept='$sdept'");
					//check wheather vote registerd or not
					if($update){
					//set student as registerd
					$set_voted_student=mysqli_query($conn,"UPDATE student_details SET vote='1' WHERE reg_no='$reg_no'");
					$output['message']="voted";
					$output['error']=false;
					}
				}
			else{
				$output['message']="unable register vote";
				$output['error']=true;
			}
			
			
		}
		else if($year == 2019 && $voted==0){
			
			$timer_details=mysqli_query($conn,"select * from vote_timers where dept='$sdept' and secretary='1'");
				$timer_row=mysqli_fetch_assoc($timer_details);
				$start=$timer_row['start'];
				$end=$timer_row['end'];
				//if is set get the secretary_candidates details
				
				if($start==1 && $end==0){
					$get_vote=mysqli_query($conn,"SELECT * from chairman_candidates where reg_no='$candidate'");
					$row=mysqli_fetch_assoc($get_vote);
			
					$vote=$row['vote_count'];
					$vote=$vote+1;
					//update vote
					$update=mysqli_query($conn,"UPDATE chairman_candidates SET vote_count='$vote' WHERE reg_no='$candidate'");
					//check wheather vote registerd or not
					if($update){
						//set student as registerd
						$set_voted_student=mysqli_query($conn,"UPDATE student_details SET vote='1' WHERE reg_no='$reg_no'");
						$output['message']="voted";
						$output['error']=false;
					}
				}
			else{
				$output['message']="unable register vote";
				$output['error']=true;
			}
		}
		else{$output['message']="already voted!!";$output['error']=true;}
		
        
}	
else
{
		
	$output['message']="fill required";
}
echo json_encode($output);	

mysqli_close($conn);
?>



