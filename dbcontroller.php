<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "10^6u#0n(-";
	private $database = "cheatengine";
	
	function __construct() {
		$conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function selectDB($conn) {
		mysqli_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysqli_query($conn,$query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($conn,$query);
		$rowcount = mysql_num_rows($result);
		return $rowcount;	
	}
}
?>