
<?php

//http://weather.cs.nuim.ie/input.php?sensor_id=1&time=1414532294&value=23

define (rc_successful, 200);
define (rc_bad_request, 404);
define (rc_server_error, 500);

//to prevent sql injection 
//validation of the input
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

/* if(!is_numeric($_REQUEST['location_id']))
{
  http_response_code(rc_bad_request);
  exit("location_id");
} */

$sensor_id = $_REQUEST['sensor_id'];
$time = $_REQUEST['time'];
$value = $_REQUEST['value'];
//$location_id = $_REQUEST['location_id'];

$sql_insert = "INSERT INTO reading SELECT null, $sensor_id, $time, $value, locationID FROM sensor join device using (deviceID) WHERE sensorID = $sensor_id";
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



