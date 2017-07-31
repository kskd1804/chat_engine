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
	
		function clearTextDate(field) {

            if (field.defaultValue == field.value){ 
				document.getElementsByTagName("INPUT")[7].setAttribute("type", "date");
				field.value = '';
			}
            else if (field.value == '')
			{ 
				document.getElementsByTagName("INPUT")[7].setAttribute("type", "email");
				field.value = field.defaultValue;
			}

        }

</script>
</head>

<body>
<div class="container" id="container">
<div class="header">
<div class="main_nav">
<div class="pic_holder" id="tilt"><div class="display_pic"><img src="<?php echo $imgURL;?>" width="200" height="200" id="display_pic"></div></div>
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
<a href="main.php"><div class="profile_content"><img src="<?php echo $_SESSION['imgURL']?>" width="30" height="30"/></div>
<div class="profile_content2"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname']?></div></a>
<div class="profile_content2"><a href="sinout.php">Logout</a></div>
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
</div>
<div class="about_us">
<div class="page_header">
<div class="page_header_img"><img src="Images/user.png" width="30" height="30"></div>
<div class="page_title">Update Details</div>
</div>
<div class="about_main">
<div class="form">
<form method="post" action="update.php">
<p>
<input type="text" name="firstname" value="<?php echo $_SESSION['firstname']?>" onBlur="clearText(this)" onFocus="clearText(this)"/>
<input type="text" name="firstname" value="<?php echo $_SESSION['lastname']?>" onBlur="clearText(this)" onFocus="clearText(this)"/>
</p>
<p>
<input type="tel" name="mobile" value="<?php echo $_SESSION['mobile']?>" onBlur="clearText(this)" onFocus="clearText(this)"/>
<input type="date" name="dob" value=""/>
</p>
<p>
<textarea name="desc" rows="7" cols="70">Description</textarea>
</p>
<p><input type="submit" name="update" value="Update!"></p>
<p>
<?php
if(isset($_POST['update'])){
	include 'config.php';
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	if(mysqli_connect_errno()){
		die('Couldn\'t connect to database!');	
	}else{
		$firstname = mysqli_real_escape_string($con,$_POST['firstname']);
		$lastname = mysqli_real_escape_string($con,$_POST['lastname']);
		$mobile = mysqli_real_escape_string($con,$_POST['mobile']);	
		$dob = mysqli_real_escape_string($con,$_POST['dob']);
		$desc = mysqli_real_escape_string($con,$_POST['desc']);
		$user = $_SESSION['email'];
		$sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', mobile='$mobile', dob='$dob', user_desc='$desc' WHERE email='$user'";
		$query = mysqli_query($con,$sql);
		if($query){
			echo 'Update Successful!';	
		}else{
			echo 'Update Unsuccessful!';	
		}
	}
}
?>
</p>
</form>
</div>
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