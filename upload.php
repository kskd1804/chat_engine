<?php
session_start();
include 'config.php';
if(isset($_POST['upload'])){
	$errors= array();
      $file_name = $_FILES['pic']['name'];
      $file_size =$_FILES['pic']['size'];
      $file_tmp =$_FILES['pic']['tmp_name'];
      $file_type=$_FILES['pic']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['pic']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="Extension not allowed! Please choose a JPEG or PNG file.";
      }
      
      if($file_size > 20097152){
         $errors[]='File size must be exactly 20 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"UserContent/".$file_name);
         $con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
		 if(mysqli_connect_errno()){
			die('Couldn\'t connect to database!');	 
		 }else{
			$file = "UserContent/".$file_name;
			$user = $_SESSION['email'];
			$sql = "UPDATE user SET imgURL='$file' WHERE email='$user'";
			$query = mysqli_query($con,$sql);
			if($query){
				header('Location: main.php');	
			}else{
				die('Upload unsuccessful!');	
			}	 
		 }
      }else{
         print_r($errors);
      }
}else echo 'File not selected!';
?>