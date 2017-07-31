<?php session_start(); ob_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ChatEngine - Connecting People</title>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

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
				document.getElementsByTagName("INPUT")[4].setAttribute("type", "password");
				field.value = '';
			}
            else if (field.value == '')
			{ 
				document.getElementsByTagName("INPUT")[4].setAttribute("type", "email");
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
<input type="password" value="" name="password_login" maxlength="50" required/>
</div>
<input type="submit" value="Login!" name="login"/>
</form>
</div>
</div>
<!--Main Nav Ends-->

<!--Header close-->

<div class="content">
<div class="content_panel2">
<div class="login_dialog">
Login - ChatEngine<hr>
<form method="post" action="login.php">
<input type="email" value="Email(Username)" name="username" onFocus="clearText(this)" onBlur="clearText(this)"/>
<input type="email" value="Password" name="password" onFocus="clearTextPassword(this)" onBlur="clearTextPassword(this)"/>
<input type="submit" value="Login to chatEngine" name="login"/>
</form>
<p style="font-size:15px"><?php 
require_once('config.php');
if(isset($_POST['login'])){
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(!mysqli_connect_errno())
{
$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);
$pass = md5($password);
$sql = "SELECT * FROM user WHERE email='$username' && password='$pass'";
$result = mysqli_query($con,$sql);
if($result){
$rows = mysqli_num_rows($result);
if($rows == 1){
$rows_return = mysqli_fetch_assoc($result);
$imgURL = $rows_return['imgURL'];
$_SESSION['firstname'] = $rows_return['firstname'];
$_SESSION['lastname'] = $rows_return['lastname'];
$_SESSION['email'] = $rows_return['email'];
$_SESSION['mobile'] = $rows_return['mobile'];
$_SESSION['dob'] = $rows_return['dob'];
$_SESSION['imgURL'] = $imgURL;
$sql = "UPDATE user SET status='online' WHERE email='$username'";
$query = mysqli_query($con,$sql);
if($query){
header('Location:main.php');
}
}else{
header('Location:login.php');	
}
}else{
echo "Invalid username/password!";	
}	
}else{
echo "Could not connect to database";	
}
}
?></p>
<div class="forgot_password"><a href="forgot.php">Forgot password?</a></div>
</div>
</div>
</div>
<center>By: K. Sai Kousthubha Das & M. Archith Reddy</center>
</div>
</body>
</html>
