<?php
include 'config.php';
session_start();
$user=$_SESSION['email'];
if(session_destroy()) // Destroying All Sessions
{
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	echo 'Couldn\'t connect to database!';	
}else{
$sql = "UPDATE user SET status='offline',last_online=NOW() WHERE email='$user'";
$query = mysqli_query($con,$sql);
if($query){
header("Location: index.php"); // Redirecting To Home Page
}
}
}
?>