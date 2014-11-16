
<?php

#login details
$password = "Links550"; 
$username = "paulina";
$database = "weather";

$connect = mysqli_connect("localhost", $username, $password, $database)
or die (mysqli_connect_error());


$q_readings = "SELECT * FROM reading 
JOIN location USING(locationID)
JOIN sensor USING(sensorID)
JOIN sensorspec USING(specID)
JOIN sensortype USING(typeID)"; 
$result = mysqli_query($connect, $q_readings) 
or die (mysqli_error($connect));

$array = array();
 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{ 
	$array[] = $row;
} 
$feed["readings"] = $array;

echo json_encode($feed);

?>
