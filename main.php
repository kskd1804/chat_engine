<?php
include('session.php');
if(!isset($_GET['user'])){
	$_GET['user'] = $_SESSION['email'];
}
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	die('Couldn\'t connect to database!');
}else{
	$user = $_GET['user'];
	$sql = "SELECT * FROM user WHERE email='$user'";
	$query = mysqli_query($con,$sql);
	if($query){
		$data = mysqli_fetch_assoc($query);
		$firstname = $data['firstname'];
		$lastname = $data['lastname'];		
		$email = $data['email'];
		$mobile = $data['mobile'];
		$dob = $data['dob'];
		$imgURL = $data['imgURL'];
		$user_desc = $data['user_desc'];
		$gender = $data['gender'];
		$desc = $data['user_desc'];
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ChatEngine</title>
<link href="css/home.css" rel="stylesheet" media="screen" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(e) {
        $("#search").keyup(function(e){
			var search_value = $("#search").val();
			if(search_value!=""){
			$("#results").load('search.php',{search_value:search_value});
			}
		});
		
		$("#recents_main").load('recents.php');

    });

 function clearText(field) {

            if (field.defaultValue == field.value){ 
				field.value = '';
				$("#results").attr("style","display:block");
			}
            else if (field.value == ''){
			 	field.value = field.defaultValue;
			}
        }
		
function collapseSearch(){
		$("#results").attr("style","display:none");
	}

</script>
</head>

<body>
<div class="container" id="container">
<div class="header">
<div class="main_nav">
<div class="pic_holder" id="tilt"><div class="display_pic"><img src="<?php echo $imgURL;?>" width="200" height="200" id="display_pic"  onClick="openFile()"/></div></div>
<div class="display_name"><?php echo $firstname." ".$lastname;?></div>
<div class="button">
<?php
if($email==$_SESSION['email']){
	echo '<a href="update.php">Update Info</a>';
}else{
	echo '<a href="home.php?to='.$email.'">Message</a>';
}
?>
</div>
<div class="logo"><a href="main.php">cE</a></div>
<input type="text" id="search" name="search" onFocus="clearText(this)" onBlur="clearText(this)" value="Search & Connect with your Friends" style="margin:5px 0 0 100px; color:#CCC; font-size:14px; float:left;"/>
<div class="results" id="results">
<div class="search_result">
<div class="search_result_name">Search and Connect to people you know!</div>
</div>
</div>
<div class="profile">
<a href="main.php">
<div class="profile_main">
<div class="profile_content"><img src="<?php echo $_SESSION['imgURL']?>" width="30" height="30"/></div>
<div class="profile_content2"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname']?></div>
</div>
</a>
<div class="profile_content3"><a href="sinout.php">Logout</a></div>
</div>
</div>
</div>
<div class="content_main" id="content"  onClick="collapseSearch()">
<div class="display">
<div class="do_you_know">
<?php
if($email==$_SESSION['email']){
	echo 'To update your profile <a href="update.php">click here!</a>';
}else{
	echo 'Do you know '.$firstname.'?<br>To send a message <a href="home.php?to='.$email.'">click here!</a>';
}
?>
</div>
<div class="do_you_know2">
<?php
if($email!=$_SESSION['email']){
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	if(mysqli_connect_errno()){
		die('Couldn\'t connect to database!');	
	}else{
		$sql = "SELECT status,last_online FROM user WHERE email='$email'";	
		$query = mysqli_query($con,$sql);
		if($query){
			$row = mysqli_fetch_assoc($query);
			if($row['status']=='online'){
				echo 'Online  <div class="online"></div>';	
			}else{
				echo 'Last seen at '.$row['last_online'].'  <div class="offline" style="margin:6px 15px 0 0;float:left;"></div>';	
			}	
		}else echo mysqli_error($con);
	}
}
?>
</div>
</div>
<div class="about_us">
<div class="page_header">
<div class="page_header_img"><img src="Images/user.png" width="30" height="30"></div>
<div class="page_title">About</div>
</div>
<div class="about_main">
<div class="about_title">Contact Information</div>
<hr style="border:0;">
<div class="def">Mobile Phone</div><div class="value"><?php echo $mobile?></div>
<div class="def">Email-ID</div><div class="value"><?php echo $email?></div>
<div class="about_title">Basic Information</div>
<hr style="border:0;">
<div class="def">Date Of Birth</div><div class="value"><?php echo $dob?></div>
<div class="def">Gender</div><div class="value"><?php echo $gender?></div>
<div class="about_title">Description</div>
<hr style="border:0;">
<div class="value" style="width:97%"><?php echo $desc?></div>
</div>

</div>
<div class="recent_chats">
<div class="page_header">
<div class="page_header_img"><img src="Images/Messages-icon.png" width="30" height="30"></div>
<div class="page_title">Your Recent Messages</div>
<div id="recents_main"></div>
</div>
</div>
</div>
</div>
</div>

</body>
</html>