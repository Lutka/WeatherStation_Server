
<?php

//http://weather.cs.nuim.ie/input.php?device_id=1&time=1414532294&value=23&sensor_type=T

//to prevent sql injection 
//validation of the input
if(!is_numeric($_REQUEST['device_id']))
{
  exit("Invalid device_id");
}

if(!is_numeric($_REQUEST['time']))
{
  exit("Invalid time");
}

if(!is_numeric($_REQUEST['value']))
{
  exit("Invalid value");
}

//echo preg_match('[A-Z]', $_REQUEST['sensor_type']);

$sensor_type_arr=array("T","H");
//in_array("Irix", $os)

if(!in_array($_REQUEST['sensor_type'], $sensor_type_arr)) 
{
  //('[A-Z]', $_REQUEST['sensor_type'])) {
  exit($_REQUEST['sensor_type']." is invalid sensor_type");
}

$device_id = $_REQUEST['device_id'];
$time = $_REQUEST['time'];
$value = $_REQUEST['value'];
$sensor_type = $_REQUEST['sensor_type'];

$sql_insert = "INSERT INTO reading VALUES(null, $time, $device_id, $value, '$sensor_type', 1)";
echo $sql_insert;   

$password = "Links550";
$username = "paulina";
$database = "weather";

$connect = mysqli_connect("localhost", $username, $password, $database)
or die (mysqli_connect_error());

 echo ("<p>Connected to database.</p>");

 if($connect) {
    if(mysqli_query($connect, $sql_insert)) {
       echo "New record added";
    }
    else
    {
      echo "Error: " . mysqli_error($connect);
    }
 }
  mysqli_close($connect);
   

?>



