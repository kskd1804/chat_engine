<?php
include('session.php');
function head($page){
	header('Location: '.$page);
}
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	die('Couldn\'t connect to database!');
}else{
	$_SESSION['to'] = $_GET['to'];
	$to = $_GET['to'];
	$user = $_SESSION['email'];
	$sql = "SELECT firstname,lastname,email,imgURL FROM user WHERE email='$to'";
	$query = mysqli_query($con,$sql);
	if($query){
		$data = mysqli_fetch_assoc($query);
		$toImg = $data['imgURL'];
		$firstname = $data['firstname'];	
		$lastname = $data['lastname'];
		$sql = "UPDATE `$to` SET status='READ' WHERE sent_recd='s' AND to_name='$user'";
		$query = mysqli_query($con,$sql);
		$sql = "UPDATE `$user` SET status='READ' WHERE sent_recd='r' AND from_name='$to'";
		$query = mysqli_query($con,$sql);
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
<script src="js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
   $("#chatText").keyup(function(e){
	   var from_name = $("#from_name").val();
	   var to_name = $("#to_name").val();
	   var msg = $("#chatText").val();
	   var sentImg = $("#toImg").val();
	   var fromImg = $("#fromImg").val();
	   var keyVals = {from_name:from_name,to_name:to_name,msg:msg,sentImg:sentImg,fromImg:fromImg};
		if(e.keyCode==13){
			$.ajax({
				type:'POST',
				url:'insertMessage.php',
				data:keyVals,
				success: function(){
					$("#chatText").val("");	
				}
			});	
		}   
	});
	
	$("#search").keyup(function(e){
			var search_value = $("#search").val();
			$("#results").load('search.php',{search_value:search_value});
		});
	$("#search").focusout(function(e) {
        $("#results").focusout(function(e) {
            $("#results").attr("style","display:none");
        });
    });
	
	setInterval(function(){
		var to_name = $("#to_name").val();
		$("#chatWindow").load("displayMessages.php",{to:to_name});
		},500);
		
	setInterval(function(){
		$("#recents").load("recents.php");
		},1000);
		
	$("#recents").load("recents.php");
});

function collapseSearch(){
		$("#results").attr("style","display:none");
		$("#settings").attr("style","display:none");
	}

 function clearText(field) {

            if (field.defaultValue == field.value){ 
				field.value = '';
				$("#results").attr("style","display:block");
			}
            else if (field.value == ''){
			 	field.value = field.defaultValue;
			}
        }
		
		function openSettings(){
		$("#settings").attr("style","display:block");	
	}
</script>
</head>

<body>
<div class="container">
<div class="header">
<div class="main_nav">

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
<div class="content"  onClick="collapseSearch()">

<div class="chatWindow">
<div class="messages">
<a href="main.php?user=<?php echo $to;?>">
<div class="heading">
<div class="heading_img"><img src="<?php echo $toImg;?>" width="30"></div>
<div class="heading_title"><?php echo $firstname." ".$lastname?></div>
<span style="margin:10px 10px 0 0;float:right;">
<?php
if(true){
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	if(mysqli_connect_errno()){
		die('Couldn\'t connect to database!');	
	}else{
		$sql = "SELECT status,last_online FROM user WHERE email='$to'";	
		$query = mysqli_query($con,$sql);
		if($query){
			$row = mysqli_fetch_assoc($query);
			if($row['status']=='online'){
				echo 'Online  <div class="online"></div>';	
			}else{
				echo 'Last seen at: '.$row['last_online'].'  <div class="offline" style="margin:6px 15px 0 0;float:left;"></div>';	
			}	
		}else echo mysqli_error($con);
	}
}
?>
</span>
</div>
</a>
<div class="messages2" id="chatWindow">
</div>
<form>
<input type="hidden" id="from_name" value="<?php echo $_SESSION['email'];?>"/>
<input type="hidden" id="to_name" value="<?php echo $to;?>"/>
<input type="hidden" id="fromImg" value="<?php echo $_SESSION['imgURL'];?>"/>
<input type="hidden" id="toImg" value="<?php echo $toImg;?>"/>
<textarea name="chatText" id="chatText"></textarea>
</form>
</div>
</div>

<div class="recents" id="recents" onClick="collapseSearch()"></div>
</div>
</body>
</html>