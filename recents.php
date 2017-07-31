<?php
session_start();
include 'config.php';
include 'classes.php';

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	die('Couldn\'t connect to database!');	
}else{
	$email = $_SESSION['email'];
	$sql = "SELECT DISTINCT from_name FROM `$email`";
	$query = mysqli_query($con,$sql);
	$recents = array();
	$i=0;
	while($row = mysqli_fetch_assoc($query)){
		$count=0;
		for($x=0;$x<$i;$x++){
			if($recents[$x]==$row['from_name']){
				$count=1;
				break;	
			}
		}
		if($count==0 && $row['from_name']!=$email){
			$recents[$i]=$row['from_name'];	
			$i++;
		}	
	}
	
	$sql = "SELECT DISTINCT to_name FROM `$email`";
	$query = mysqli_query($con,$sql);
	while($row = mysqli_fetch_assoc($query)){
		$count=0;
		for($x=0;$x<$i;$x++){
			if($recents[$x]==$row['to_name']){
				$count=1;
				break;	
			}
		}
		if($count==0 && $row['to_name']!=$email){
			$recents[$i]=$row['to_name'];	
			$i++;
		}	
	}
	
	for($x=0;$x<$i;$x++){
		$user = $recents[$x];
		$sql = "SELECT * FROM `$email` WHERE from_name='$user' OR to_name='$user' ORDER BY datetime DESC LIMIT 1";
		$query = mysqli_query($con,$sql);
		if($query){
			$row = mysqli_fetch_assoc($query);
			$sql = "SELECT imgURL,status,firstname FROM user WHERE email='$user'";
			$query = mysqli_query($con,$sql);
			$row_user = mysqli_fetch_assoc($query);
			if($row['sent_recd']=='s') $row['msg'] = 'You: '.$row['msg'];
			if($row['status']=='READ'|| $row['sent_recd']=='s'){
			echo '<a href="home.php?to='.$user.'"><div class="recent_chat">
				  <img src="'.$row_user['imgURL'].'" width="20" height="20" class="profile_pic"/>
				  <div class="recent_chat_content">
				  <span style="color:#000;font:\'Times New Roman\';white-space:nowrap;overflow:hidden;">'.$row_user['firstname'].'</span>
				  <span style="color:#ccc;font-size:12px;"><br>'.$row['msg'].'</span>
				  </div>
				  <div class="'.$row_user['status'].'"></div>
				  </div>';
			}else if($row['status']=='SENT' && $row['sent_recd']=='r'){
				echo '<a href="home.php?to='.$user.'"><div class="recent_chat_unread">
				  <img src="'.$row_user['imgURL'].'" width="20" height="20" class="profile_pic"/>
				  <div class="recent_chat_content">
				  <span style="color:#FFF;font:\'Times New Roman\';white-space:nowrap;overflow:hidden;">'.$row_user['firstname'].'</span>
				  <span style="color:#ccc;font-size:12px;"><br>'.$row['msg'].'</span>
				  </div>
				  <div class="'.$row_user['status'].'"></div>
				  </div>';
			}
		}
	}
}
?>