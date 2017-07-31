<?php
require_once('config.php');
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);

session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['firstname'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysqli_query($connection, "SELECT firstname FROM user WHERE firstname='$user_check'");
$row = mysqli_num_rows($ses_sql);
if($row == 0){
mysqli_close($connection); // Closing Connection
header('Location: index.php'); // Redirecting To Home Page
exit();
}
?>