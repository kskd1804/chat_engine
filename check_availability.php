<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$connect = mysqli_connect("localhost","root","10^6u#0n(-","cheatengine");

if(!empty($_POST["username"])) {
	if($_POST["username"] == 'Email(Username)' || $_POST["username"]==''){echo "<font color=\"#CC0000\"> Please enter email!</span>";}
	else{
  $result = mysqli_query($connect,"SELECT count(*) FROM user WHERE email='" . $_POST["username"] . "'");
  $row = mysqli_fetch_row($result);
  $user_count = $row[0];
  if($user_count>0) {
      echo "<font color=\"#CC0000\"> Username Not Available.</span>";
  }else{
      echo "<font color=\"#551A8B\"> Username Available.</span>";
  }
	}
}
?>