<?php
session_start();
include 'config.php';
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	die('Couldn\'t connect to database!');	
}else{
	$to = $_POST['to'];
	$user = $_SESSION['email'];
	$sql = "SELECT * FROM `$user` WHERE from_name='$to' OR to_name='$to'";
	$query = mysqli_query($con,$sql);
	if($query){
		while($messages = mysqli_fetch_assoc($query)){
			if($messages['sent_recd']=='s'){
				echo '<div class="message" id="last">
					  <div class="sender">
					  <div class="message_text">'.$messages['msg'].'</div>
					  <img src="'.$messages['imgURL'].'" width="15" height="15" class="dp_img_sender"/>
					  </div>
					  </div>';
			}else{
				echo '<div class="message"  id="last">
					  <div class="reciever">
					  <div class="message_text">'.$messages['msg'].'</div>
					  <img src="'.$messages['imgURL'].'" width="15" height="15" class="dp_img_reciever"/>
					  </div>
					  </div>';	
			}	
		}
	}
}
?>