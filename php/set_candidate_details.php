<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','sona');

$conn=mysqli_connect(HOST,USER,PASS,DB) or die("Unable to connect");
$admin_reg_no=$_GET['admin_reg_no'];
$reg_no1=$_GET['c1'];
$reg_no2=$_GET['c2'];
$reg_no3=$_GET['c3'];
$reg_no4=$_GET['c4'];
$post=$_GET['post'];
$output=array();

$reg_nos=array($reg_no1,$reg_no2,$reg_no3,$reg_no4);

$i=0;
//$count=count($reg_nos);

if(isset($_GET['post']))
{
	$admin=mysqli_query($conn,"select * from admin_details where reg_no='$admin_reg_no'");
	$rows1=mysqli_fetch_assoc($admin);
	$adept=$rows1['dept'];
	if(!strcmp($post,"secretary")){
		
			while($i<4){
		
			//echo $reg_nos[$i]."<br/>";
	
			$res=mysqli_query($conn,"select * from student_details where reg_no='$reg_nos[$i]'");
			$rows=mysqli_fetch_assoc($res);
			$name=$rows['name'];
			$sdept=$rows['dept'];
			$year=$rows['batch'];
			if($year==2020 ){
				if(!strcmp($sdept,$adept)){
				$insert=mysqli_query($conn,"INSERT INTO secretary_candidates(reg_no,name,dept) VALUES ('$reg_nos[$i]','$name','$sdept')");
				$output['error']=false;
				$output['message']=$reg_nos[$i];}
				
				else{$output['message']="Some are not from your department";
				$output['error']=true;}
			}
			else{$output['message']="not from 3 yr";$output['error']=true;}
			$i++;
		}
	}
	elseif(!strcmp($post,"chairman")){
		for($i=0;$i<$count;$i++){
			//echo $reg_nos[$i];
	
			$res=mysqli_query($conn,"select * from student_details where reg_no='$reg_nos[$i]'");
			$rows=mysqli_fetch_assoc($res);
			$name=$rows['name'];
			$year=$rows['batch'];
			if($year==2019){
				if(!strcmp($sdept,$adept)){
				$insert=mysqli_query($conn,"INSERT INTO chairman_candidates(reg_no,name) VALUES ('$reg_nos[$i]','$name')");
				$output['message']="inserted";
				$output['error']=false;}
				else{$output['message']="Some are not from your department";$output['error']=true;}
			}
			else{$output['message']="not from 4 yr";$output['error']=true;}
		}
	}
	else{$output['message']="enter post";$output['error']=true;}
}
	
else
{
		
	$output['message']="fill required";$output['error']=true;
}
echo json_encode($output);	

mysqli_close($conn);
?>




