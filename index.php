<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>
<html>
<body>

<?php

include("connect.php");

#echo ("<p>Connected to database.</p>");
echo ("<p>Weather Station Readings</p>");

$query = "SELECT * FROM reading ORDER BY time DESC LIMIT 100";  
$result = mysqli_query($connect, $query) 
or die (mysqli_error($connect));


echo "<table class='table table-hover'>
<thead>
	<tr>
		<th>ReadingID</th>
		<th>SensorID</th>
		<th>Time</th>
		<th>Value</th>
		<th>LocationID</th>
	</tr>
</thead>";
 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{ 
	$date=gmdate("Y-m-d\ | H:i:s\ ", $row[Time]);
	echo"<tr> 
	<td> $row[ReadingID] </td>
	<td> $row[SensorID] </td>
	<td> $date </td>   
	<td> $row[Value] </td>
	<td> $row[LocationID] </td> 
	</tr>";	
} 

echo "</table>";
?>
<body>
</html>