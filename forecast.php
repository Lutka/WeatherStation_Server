<?php

include("connect.php");

$json = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?lat=53.3083022&lon=-6.3798955")
	or Die("Error fetching weather forecast");
$obj = json_decode($json);

$locationComment = ($obj->city->name);

$lat =($obj->city->coord->lat);
//print_r($lat);
$lon =($obj->city->coord->lon);
//print_r($lon);

$sql_time = "SELECT time FROM reading WHERE sensorID IN (3, 4) ORDER BY time DESC LIMIT 1";
$result = mysqli_query($connect, $sql_time) 
or die (mysqli_error($connect));

if($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
	$timeStamp=$row['time'];  
	echo $timeStamp;
	
$sensor_id_t=3;
$sensor_id_h=4;

$sql_insert = "INSERT INTO reading SELECT null, ?, ? ,?, locationID FROM sensor join device using (deviceID) WHERE sensorID = ?";

//chyba  przydalo by sie wziac najnowszy czas i pozniej patrzec na wartosci,
// ktore maja tylko wiekszy czas - nowszy

//$currentTime = 1317641200;
//count($obj->list)
for ($i = 0; $i < count($obj->list); $i++)
{
	$time =($obj->list[$i]->dt);	
	
	if($time > $timeStamp) 
	{
		//echo $i . "<br>";
		echo "<br>";
		print_r($time);
		echo "<br>";

		//conversion from Kelvin to Celsius
		$temp = ($obj->list[$i]->main->temp) - 273.15;
		print_r($temp);
		echo "<br>";

		$humidity = ($obj->list[$i]->main->humidity);
		print_r($humidity);
		echo "<br>";
		$reading = mysqli_prepare($connect, $sql_insert);
		mysqli_stmt_bind_param($reading, "dddd", $sensor_id_t, $time, $temp, $sensor_id_t);
		if(mysqli_stmt_execute($reading))
		{
			echo "New record added: " . mysqli_insert_id($connect);
		}
		else echo mysqli_error($connect);
		
		$reading = mysqli_prepare($connect, $sql_insert);
		mysqli_stmt_bind_param($reading, "dddd", $sensor_id_h, $time, $humidity, $sensor_id_h);	
		if(mysqli_stmt_execute($reading))
		{
			echo "New record added: " . mysqli_insert_id($connect);
		}
		else echo mysqli_error($connect);
	}	
}
 mysqli_close($connect); 
?>