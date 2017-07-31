<?php
session_start();
include 'config.php';
if(isset($_POST['msg'])){
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	if(mysqli_connect_errno()){
		die('Couldn\'t connect to database!');		
	}else{
		$from_name = mysqli_real_escape_string($con,$_POST['from_name']);
		$to_name = mysqli_real_escape_string($con,$_POST['to_name']);
		$msg = mysqli_real_escape_string($con,$_POST['msg']);
		$recvImg = mysqli_real_escape_string($con,$_POST['sentImg']);
		$senderImg = mysqli_real_escape_string($con,$_POST['fromImg']);
		$sql = "INSERT INTO `$from_name` (from_name,to_name,msg,sent_recd,datetime,imgURL) VALUES ('$from_name','$to_name','$msg','s',NOW(),'$senderImg')";
		$query = mysqli_query($con,$sql);
		if($query){
			$sql = "INSERT INTO `$to_name` (from_name,to_name,msg,sent_recd,datetime,imgURL) VALUES ('$from_name','$to_name','$msg','r',NOW(),'$senderImg')";	
			$query = mysqli_query($con,$sql);
		}
	}
}
?>