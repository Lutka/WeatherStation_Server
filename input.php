<?php
include("connect.php");
//http://weather.cs.nuim.ie/input.php?sensor_id=1&time=1414532294&value=23
define ("rc_successful", 200);
define ("rc_bad_request", 404);
define ("rc_server_error", 500);
define ("rc_duplicate", 409);

//to prevent sql injection: validation of the input
if(!is_numeric($_REQUEST['sensor_id']))
{
  http_response_code(rc_bad_request);
  exit("Invalid sensor_id");  
}

if(!is_numeric($_REQUEST['time']))
{
  http_response_code(rc_bad_request);
  exit("Invalid time");
}

if(!is_numeric($_REQUEST['value']))
{
  http_response_code(rc_bad_request);
  exit("Invalid value");
}

$sensor_id = $_REQUEST['sensor_id']; 
$time = $_REQUEST['time'];
$value = $_REQUEST['value'];
$locationID = 1;

echo ("<p>Connected to database.</p>");

$sql_insert = "INSERT INTO reading SELECT null, ?, ? ,?, locationID FROM sensor join device using (deviceID) WHERE sensorID = ?";

$reading = mysqli_prepare($connect, $sql_insert);
mysqli_stmt_bind_param($reading, "dddd", $sensor_id, $time, $value, $sensor_id);
 
//getting appropriate response_code
if($connect) 
{
	echo "I am connected";
	if(mysqli_stmt_execute($reading)) 
	{
		http_response_code(rc_successful); 
		echo "New record added";
	}
	else
	{	
		echo "Duplicate error" . mysqli_errno($connect);  
		if(mysqli_errno($connect) == 1062)
		{
			http_response_code(rc_duplicate);
			echo "Error: Duplicate Entry ";
		}
		else
		{
		  http_response_code(rc_server_error);
		  echo "Error: " . mysqli_error($connect);
		}
	}
}
mysqli_close($connect);   
?>