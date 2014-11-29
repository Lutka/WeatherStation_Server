<?php

$json = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?lat=53.3083022&lon=-6.3798955")
	or Die("Error fetching weather forecast");
$obj = json_decode($json);
$locationComment = ($obj->city->name);

$lat =($obj->city->coord->lat);
//print_r($lat);
$lon =($obj->city->coord->lon);
//print_r($lon);

//chyba  przydalo by sie wziac najnowszy czas i pozniej patrzec na wartosci,
// ktore maja tylko wiekszy czas - nowszy

$currentTime = 1317641200;

for ($i = 0; $i < count($obj->list); $i++)
{
	$time =($obj->list[$i]->dt);
	
	
	if($time > $currentTime) 
	{
		echo $i . "<br>";
		echo "<br>";
		//$time =($obj->list[$i]->dt);
		print_r($time);
		echo "<br>";

		//conversion from Kelvin to Celsius
		$temp = ($obj->list[$i]->main->temp) - 273.15;
		print_r($temp);
		echo "<br>";

		$humidity = ($obj->list[$i]->main->humidity);
		print_r($humidity);
		echo "<br>";
	}
}


?>