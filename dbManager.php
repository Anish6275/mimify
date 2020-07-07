<?php
$servername="localhost";
$username="id13932939_mimifyuser";
$password="GCV4yHcFD+MpnxD5";
$database="id13932939_mimify";
$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
	die("Failed to connect". mysqli_connect_error());
}
?>