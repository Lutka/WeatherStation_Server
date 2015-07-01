<html>
<head>
<!--style for table display -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>
<body>

<?php
include("connect.php");

#echo ("<p>Connected to database.</p>");
echo ("<p>Weather Station Readings</p>
<p>r - real readings</p>
<p>f - forecast data</p>");  

#database query
$query = "SELECT time, value, reading.locationID, sensorSpec.typeID, device.deviceType, location.comment
FROM reading
JOIN sensor USING (sensorID) 
JOIN device USING(deviceID)
JOIN location ON(reading.locationID= location.locationID)
JOIN sensorSpec USING (specID)
JOIN sensorType USING (typeID)
ORDER BY time DESC";    
$result = mysqli_query($connect, $query)  
or die (mysqli_error($connect));

$readings = array();
$lastReading = null;

 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{	
	if($lastReading != null)
	{
		if($lastReading["time"] == $row["time"] && $lastReading["deviceType"] == $row["deviceType"])
		{
			if($row[typeID] =='H')
			{
				$readings[sizeof($readings)-1]["humidity"] = $row["value"];
			}
			else
			{
				$readings[sizeof($readings)-1]["temperature"] = $row["value"]; 
			}
			continue;
		}
	} 	
	
	if($row[typeID] =='H')
	{	
		$row["humidity"] = $row["value"];
	}	
	else ##($row[typeID] =='T')
	{
		$row["temperature"] = $row["value"];
	}
	
	$lastReading = $row;
	$readings[] = $lastReading;
}

echo "<table class='table table-hover'>
<thead>
	<tr>
		<th>Time</th>
		<th>Location</th>
		<th>Temperature</th>
		<th>Humidity</th>
		<th>Type</th>
	</tr>
</thead>";  

###time,location.comment, value, units, device.deviceType, 
for($i = 0; $i < sizeof($readings); $i++) 
{ 
	$row = $readings[$i]; 

	$date = gmdate("Y-m-d\ | H:i:s\ ", $row["time"]);
	if($row["deviceType"] == 'r')
	{
	echo"<tr bgcolor='#6cc534'>
		<td> $date </td> 
		<td> $row[comment] </td>	
		<td> $row[temperature] &degC </td>
		<td> $row[humidity] % </td>		 
		<td> $row[deviceType] </td>
		</tr>";	
	}
	else
	{
		echo"<tr bgcolor='#eff67b'> 
		<td> $date </td> 
		<td> $row[comment] </td>	
		<td> $row[temperature] &degC </td>
		<td> $row[humidity] % </td>		 
		<td> $row[deviceType] </td>
		</tr>";	 
	}
} 

echo "</table>";
?>
</body>
</html>
