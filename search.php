<?php
session_start();
include 'config.php';
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	die('Couldn\'t connect to database!');
}else{
	$search_value = mysqli_real_escape_string($con,$_POST['search_value']);
	$sql = "SELECT firstname,lastname,imgURL,email FROM user WHERE firstname LIKE '%$search_value%' OR lastname LIKE '%$search_value%' OR email LIKE '%$search_value%' OR CONCAT(firstname,lastname) LIKE '%$search_value'";
	$query = mysqli_query($con,$sql);
	if($query){
		$count = mysqli_num_rows($query);
		if($count!=0){
				while($rows = mysqli_fetch_assoc($query)){
					echo '<a href="main.php?user='.$rows['email'].'">
					<div class="search_result">
					<div class="search_result_img"><img src="'.$rows['imgURL'].'" width="35" height="37"></div>
					<div class="search_result_name">'.$rows['firstname'].' '.$rows['lastname'].'</div>
					</div>
					</a>';	
				}	
		}else{
			echo '<span><center><b>No records available!</b></center></span>';	
		}	
	}else{
		echo 'Query Unsuccessful!!!';	
	}	
}
?>