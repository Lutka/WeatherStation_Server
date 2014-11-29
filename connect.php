<?php

#login details
$password = "Links550"; 
$username = "paulina";
$database = "weather";

$connect = mysqli_connect("localhost", $username, $password, $database)
or die (mysqli_connect_error());

?>