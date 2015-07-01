<?php
#login details
$password = ""; 
$username = "";
$database = "weather";

$connect = mysqli_connect("localhost", $username, $password, $database)
or die (mysqli_connect_error());
?>