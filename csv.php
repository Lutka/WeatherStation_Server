<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>
<body>

<?php

include("connect.php");

#echo ("<p>Connected to database.</p>");

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

$readings=array();
$lastReading=null;

 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
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
		$row["humidity"]=$row["value"];
	}	
	else ##($row[typeID] =='T')
	{
		$row["temperature"] = $row["value"];
	}
	
	$lastReading=$row;
	$readings[]=$lastReading;
}

echo "<table class='table table-hover'>
<thead>
	<tr>
		<th>Time,
		Value,
		Measurement Type,
		Reading Type</th>
	</tr>
</thead>";

###time, value, reading.locationID, sensorSpec.typeID, device.deviceType, location.comment
for($i=0; $i < sizeof($readings); $i++) 
{ 
	$row=$readings[$i]; 

	$date= $row["time"];
	if($row["deviceType"] == 'r' && $row[typeID] =='T')
	{
		echo"<tr bgcolor='#6cc534'>
			<td> $row[time], 	
			 $row[value], 	
			 $row[typeID],
			 $row[deviceType] </td>
		</tr>";	
	}
	else if($row["deviceType"] == 'f' && $row[typeID] =='T')
	{
		echo"<tr bgcolor='#6cc534'>
			<td> $row[time], 	
			 $row[value], 	
			 $row[typeID],
			 $row[deviceType] </td>
		</tr>";	
	}
	else if($row["deviceType"] == 'r' && $row[typeID] =='H')
	{
		echo"<tr bgcolor='#6cc534'>
			<td> $row[time], 	
			 $row[value], 	
			 $row[typeID],
			 $row[deviceType] </td>
		</tr>";		
	}
	
	else if($row["deviceType"] == 'f' && $row[typeID] =='H')
	{
		echo"<tr bgcolor='#6cc534'>
			<td> $row[time], 	
			 $row[value], 	
			 $row[typeID],
			 $row[deviceType] </td>
		</tr>";		
	}
	
} 

echo "</table>";
?>
</body>
</html>