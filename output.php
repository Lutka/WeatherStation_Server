
<?php
include("connect.php");

$q_readings = "SELECT * FROM reading 
JOIN location USING(locationID)
JOIN sensor USING(sensorID)
JOIN sensorspec USING(specID)
JOIN sensortype USING(typeID)
ORDER BY time"; 
$result = mysqli_query($connect, $q_readings) 
or die (mysqli_error($connect));

$temperatureArray = array(); 
$humidityArray = array();
 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{ 
	#cast in order to have values in json as integers, so without quotes
	$row["SpecID"] = intval($row["SpecID"]); 
	$row["SensorID"] = intval($row["SensorID"]); 
	$row["LocationID"] = intval($row["LocationID"]);
	$row["ReadingID"] = intval($row["ReadingID"]); 
	$row["Time"] = intval($row["Time"]); 
	$row["Value"] = intval($row["Value"]); 
	$row["Latitude"] = floatval($row["Latitude"]);  
	$row["Longitude"] = floatval($row["Longitude"]); 
	$row["DeviceID"] = intval($row["DeviceID"]);
	$row["Accuracy"] = intval($row["Accuracy"]); 
	$row["Minimum"] = intval($row["Minimum"]);
	$row["Maximum"] = intval($row["Maximum"]); 
	
	if($row["TypeID"] == "T") 
	{
		$temperatureArray[] = $row; 
	}
	else
	{
		$humidityArray[] = $row;
	}
} 
$feed["TemperatureReadings"] = $temperatureArray;
$feed["HumidityReadings"] = $humidityArray;

echo json_encode($feed);

?>
