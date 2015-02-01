
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

$temperatureRealArray = array(); 
$humidityRealArray = array();
$temperatureForecastArray = array();
$humidityForecastArray = array();

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
	
	if($row["TypeID"] == "T" && ($row["SensorID"] == "1" || $row["SensorID"] == "5") ) 
	{
		$temperatureRealArray[] = $row; 
	}

	if($row["TypeID"] == "T" && $row["SensorID"] == "3") 
	{
		$temperatureForecastArray[] = $row; 
	}
	if($row["TypeID"] == "H" && ($row["SensorID"] == "2" || $row["SensorID"] == "6")) 
	{
		$humidityRealArray[] = $row;
	}	
	if($row["TypeID"] == "H" && $row["SensorID"] == "4") 
	{
		$humidityForecastArray[] = $row; 
	}
} 
$feed["TemperatureReadings"] = $temperatureRealArray;
$feed["HumidityReadings"] = $humidityRealArray;
$feed["TemperatureForecast"] = $temperatureForecastArray;
$feed["HumidityForecast"] = $humidityForecastArray;

echo json_encode($feed);

?>
