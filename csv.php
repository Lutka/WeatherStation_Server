<?php
include("connect.php");
$temperatureQuery = "SELECT time, value as forecast, 
(SELECT  value FROM reading AS readingObserved  where sensorID=5  AND ABS(readingObserved.time - reading.time) < 300 LIMIT 1) AS observed 
FROM reading 
JOIN sensor USING (sensorID) 
JOIN sensorSpec USING (specID)
JOIN sensorType USING (typeID) 
where (sensorID = 3) 
having observed is not null
ORDER BY time DESC";    

$humidityQuery = "SELECT time, value as forecast, 
(SELECT  value FROM reading AS readingObserved  where sensorID=6  AND ABS(readingObserved.time - reading.time) < 300 LIMIT 1) AS observed 
FROM reading 
JOIN sensor USING (sensorID) 
JOIN sensorSpec USING (specID)
JOIN sensorType USING (typeID) 
where (sensorID = 4) 
having observed is not null
ORDER BY time DESC";  

$result = mysqli_query($connect, $temperatureQuery)  
or die (mysqli_error($connect));

echo "time,forecast,observed\n";
while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{	
	echo "$row[time],$row[forecast],$row[observed]\n";
}