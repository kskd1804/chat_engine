<?php 
session_start(); ob_start();
if(isset($_SESSION['firstname'])){
	header('Location:main.php');
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ChatEngine - Connecting People</title>
<script src="js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">

function checkAvailability() {
	if($("#username").val()!=''||$("#username").val()!='Email(Username)')
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability.php",
	data:'username='+$("#username").val(),
	type: "POST",
	success:function(data){
		if(data=='<font color=\"#551A8B\"> Username Available.</span>')
		$("#username").attr('class','success_check');
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
	
        function clearText(field) {

            if (field.defaultValue == field.value) field.value = '';
            else if (field.value == '') field.value = field.defaultValue;
			
        }
		
		function clearTextPassword(field) {

            if (field.defaultValue == field.value){ 
				document.getElementsByTagName("INPUT")[8].setAttribute("type", "password");
				field.value = '';
			}
            else if (field.value == '')
			{ 
				document.getElementsByTagName("INPUT")[8].setAttribute("type", "email");
				field.value = field.defaultValue;
			}

        }
		
		function clearTextConfirmPassword(field) {

            if (field.defaultValue == field.value){ 
				document.getElementsByTagName("INPUT")[8].
				field.value = '';
			}
            else if (field.value == '')
			{ 
				document.getElementsByTagName("INPUT")[8].setAttribute("type", "email");
				field.value = field.defaultValue;
			}

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
		
		function YesnoCheck(field) {
			if (document.getElementById('yesCheck').checked) {
        		document.getElementById('ifYes').style.visibility = 'visible';
    		}
    		else document.getElementById('ifYes').style.visibility = 'hidden';
		}

    </script>
<link href="css/index.css" rel="stylesheet" media="screen" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>

<style type="text/css">
.character{
	width:150px;
	height:200px;
	margin:0 50px 0 0;
	padding:0;
	float:left;
}

.character_2{
	width:150px;
	height:200px;
	padding:0;
	float:left;
}

#user-availability-status{
	position:absolute;
	padding:10px 0 0 0;
	left:400px;
	font-size:15px;
}

.success_check{
	width:428px;
	margin:0 2px 0 2px;
	height:30px;
	font-size:16px;
	color:#ccc;
	padding:5px;
	border:1px solid #551A8B;
	border-radius:5px;
}
</style>
</head>

<body>
<div class="container">
<div class="header">
<!--Main Nav Starts-->
<div class="main_nav">
<div class="main_nav_logo"><a href="index.php">chatEngine</a></div>
<form class="login" method="post" action="login.php">
<div class="insert">
<div class="title">Username:</div>
<input type="email" value="" name="username" maxlength="200" required/>
</div>
<div class="insert">
<div class="title">Password:</div>
<input type="password" value="" name="password" maxlength="50" required/>
</div>
<input type="submit" value="Login!" name="login"/>
</form>
</div>
</div>
<!--Main Nav Ends-->

<!--Header close-->

<div class="content">
<div class="content_panel">
<div class="content_panel_desc_2">
<fieldset>
<font size="+3">SignUp now for free!</font>
<form method="post" action="index.php" style="margin:30px 0 0 0">
<p>
<input type="text" value="First Name" name="first_name" required onFocus="clearText(this)" onBlur="clearText(this)" maxlength="150" />
<input type="text" value="Last Name" name="last_name" required onFocus="clearText(this)" onBlur="clearText(this)" maxlength="150"/>
</p>
<p>
<input id="username" type="email" value="Email(Username)" name="email" required onFocus="clearText(this)" onBlur="checkAvailability()" maxlength="200"/>
<span id="user-availability-status"><img id="loaderIcon" src="Images/LoaderIcon.gif" width="20" style="margin:0 0 0 110px;display:none"></span>
</p>
<p>
<input type="tel" value="Mobile" name="mobile" required onFocus="clearText(this)" onBlur="clearText(this)" maxlength="10" />
</p>
<p>
<input type="email" name="dob" value="Date of Birth" required onFocus="clearTextDate(this)" onBlur="clearTextDate()" maxlength="11" />
</p>
<p>
<input type="email" value="Password" name="password_register" required onFocus="clearTextPassword(this)" onBlur="clearTextPassword(this)"maxlength="50"/>
</p>
<p style="font-size:15px; margin:15px">
<font size="+1">Gender:</font>
<input type="radio" name="gender" value="Male" checked/>Male
<input type="radio" name="gender" value="Female" />Female
</p>
<p>
<input type="submit" value="Register!" name="register"/>
</p>
<p class="success">
<?php
require_once('config.php');
if(isset($_POST['register'])){
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	if(mysqli_connect_errno())
	{
		echo "Error: Please try again!";
	}else{
		$first_name = mysqli_real_escape_string($con,$_POST['first_name']);
		$last_name = mysqli_real_escape_string($con,$_POST['last_name']);
		$email = mysqli_real_escape_string($con,$_POST['email']);
		$mobile = mysqli_real_escape_string($con,$_POST['mobile']);
		$gender = mysqli_real_escape_string($con,$_POST['gender']);
		$dob = mysqli_real_escape_string($con,$_POST['dob']);
		$password_register = mysqli_real_escape_string($con,$_POST['password_register']);
		$pass = md5($password_register);
		$sql = "INSERT INTO user (firstname,lastname,email,mobile,dob,password,gender,joineddate,msgtable,status) VALUES ('$first_name','$last_name','$email','$mobile','$dob','$pass','$gender',CURRENT_DATE(),'$email','online')";
		$query = mysqli_query($con,$sql);
		if(!$query){
			echo mysqli_error($con);
			echo "Please check your content again!";	
		}
		else{
			$sql = "CREATE TABLE `$email` ( id int NOT NULL AUTO_INCREMENT, from_name VARCHAR(200) NOT NULL, to_name VARCHAR(200) NOT NULL, msg TEXT(500) NOT NULL,sent_recd VARCHAR(2) NOT NULL, datetime VARCHAR(40) NOT NULL,status VARCHAR(15) NOT NULL DEFAULT 'SENT',imgURL VARCHAR(250) NOT NULL, PRIMARY KEY(id))";
			$query = mysqli_query($con,$sql);
			$_SESSION['firstname'] = $first_name;
			$_SESSION['lastname'] = $last_name;
			$_SESSION['email'] = $email;
			$_SESSION['mobile'] = $mobile;
			$_SESSION['dob'] = $dob;
			$_SESSION['imgURL'] = 'UserContent/profile_00.jpg';
			header('Location: main.php');
		}	
	}
}
?>
</p>
</form>
</fieldset>
</div>
<div class="content_panel_desc"><center>Dive into the world of Messaging</center>
</div>
<div class="animation_content">
<div class="character"><img src="Images/Lost_person.png" width="150" height="200"></div>
<div class="character_2"><img src="Images/Lost_person_2.png" width="150" height="200"></div>
</div>
</div>
</div>
<center>By: K. Sai Kousthubha Das & M. Archith Reddy</center>
</div>
</body>
</html>
