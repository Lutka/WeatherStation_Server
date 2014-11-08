
<?php

//http://weather.cs.nuim.ie/input.php?device_id=1&time=1414532294&value=23&sensor_type=T

define (rc_successful, 200);
define (rc_bad_request, 404);
define (rc_server_error, 500);

//to prevent sql injection 
//validation of the input
if(!is_numeric($_REQUEST['device_id']))
{
  http_response_code(rc_bad_request);
  exit("Invalid device_id");  
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

$sensor_type_arr=array("T","H");

if(!in_array($_REQUEST['sensor_type'], $sensor_type_arr)) 
{
  http_response_code(rc_bad_request);
  
  //('[A-Z]', $_REQUEST['sensor_type'])) {
  exit($_REQUEST['sensor_type']." is invalid sensor_type");
}

$device_id = $_REQUEST['device_id'];
$time = $_REQUEST['time'];
$value = $_REQUEST['value'];
$sensor_type = $_REQUEST['sensor_type'];

$sql_insert = "INSERT INTO reading SELECT null, $time, $device_id, $value, '$sensor_type', locationID FROM device WHERE deviceID = $device_id";
echo $sql_insert;   

$password = "Links550";
$username = "paulina";
$database = "weather";

$connect = mysqli_connect("localhost", $username, $password, $database)
or die (mysqli_connect_error());

 echo ("<p>Connected to database.</p>");

 if($connect) {
    if(mysqli_query($connect, $sql_insert)) {
	   http_response_code(rc_successful);
       echo "New record added";
    }
    else
    {
	  http_response_code(rc_server_error);
      echo "Error: " . mysqli_error($connect);
    }
 }
  mysqli_close($connect);   

?>



