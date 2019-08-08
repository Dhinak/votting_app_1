<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");

$reg_no=$_GET['reg_no'];
$post=$_GET['post'];
$start=$_GET['start'];
$end=$_GET['end'];
//$duration=$_GET['duration'];
$posting;

$output=array();

if(isset($_GET['reg_no']) && isset($_GET['post'])){
	$get_detail=mysqli_query($conn,"SELECT  * from admin_details where reg_no='$reg_no'");
	$row=mysqli_fetch_assoc($get_detail);
	$adept=$row['dept'];
	
	if(!strcmp($post,"secretary")){
		if($start==1 && $end==0)
		{
			$insert=mysqli_query($conn,"INSERT INTO vote_timers(dept,start,end,secretary,chairman) VALUES ('$adept','1','0','1','0')");
			$output['message']="$adept dept secretary election time started...";
			$output['error']=false;
		} 
		else if($start==0 && $end==1)
		{
			$insert=mysqli_query($conn,"UPDATE vote_timers SET start='0',end='1',secretary='0' where dept='$adept'and secretary='1'");
			$output['message']="$adept dept secretary election time ended...";
			$output['error']=false;
		} 
		
	}
	
	elseif(!strcmp($post,"chairman"))
	{
		if($start==1 && $end==0)
		{
			$insert=mysqli_query($conn,"INSERT INTO vote_timers(dept,start,end,chairman) VALUES ('$adept','1','0','1')");
			$output['message']="chairman election time started...";
			$output['error']=false;
		} 
		else if($start==0 && $end==1)
		{
			$insert=mysqli_query($conn,"UPDATE vote_timers SET start='0',end='1',update='0' where dept='$adept'and chairman='1'");
			$output['message']="chairman election time ended...";
			$output['error']=false;
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



