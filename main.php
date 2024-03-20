<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);

?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kontaktformular</title>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
          </script>
    <!-- Bootstrap -->
   <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <style>
  		html {
			background: ##8BD1ED;
  			background: url("weather_background.jpg") no-repeat center center;
  			-webkit-background-size: cover;
  			-moz-background-size: cover;
  			-o-background-size: cover;
  			background-size: cover;
  			height: 100%;
  			text-align: center;
  		}

  		body {
  			background: none;
  			color: #f9fff9;
  			height: 100%;
  		}
 
  		.jumbotron {
  			background: none;
  			top: 60px;	
  			left: 12%;
  			right: 12%;
		}

		button {
			margin-top: 30px;
		}

		#infoBox {
			margin-top: 30px;
			padding: 5px;
			background: rgb(192, 229, 192, 0.9);
			min-height: 100px;
			color: black;
		}

		h3 {
			padding-bottom: 0px;
		}

  	</style>
  </head>
  
  <body>
  	<div class="container h-100 d-flex">
  		<div class="jumbotron text-center">
  			<h1>Wettervorhersage</h1>
  			<p> Schreibe den Namen einer Stadt, um die Wettervorhersage zu sehen. </p>

  			<form>
  				<input type="text" name="inputCity" id="inputCity" class="form-control input-lg" placeholder="z.B.: Berlin" 
  				value=<?php 

$city = $_GET['inputCity'];
echo $city; ?> > 

  				<button type="submit" id="button" class="btn btn-success btn-lg"> Wettervorhersage suchen </button>
  			</form>

 <?php


if(isset($_GET['inputCity'])) {
	echo "<div id=\"infoBox\" class=\"panel=\">
  				<div class=\"panel-body\" id=\"weatherText\">";

  // Inhalt von der Webseite mit dem eingegebenen Stadt
  $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".urlencode($city)."&lang=de&appid=d3cd1809bdf3bd3ffc507a4c9be428e0");

	if($urlContents) {

		// Derr Inhalt wird in ein Array gespeichert
		$weatherArray = json_decode($urlContents, true);

		// Inhalt ders Arrays an der Stelle 'weather' im Array (Array im Array) 0 an der Stelle 'description'
		$weather = $weatherArray['weather'][0]['description'];

		$kelvinInCelsius = -273.15;

		$temperatureInCelsius = round($weatherArray['main']['temp'] + $kelvinInCelsius);

		$feelTemperature = round($weatherArray['main']['feels_like'] + $kelvinInCelsius);

		$windSpeed = round($weatherArray['wind']['speed'], 1);

		echo "Das Wetter in ". $city." ist momentan '".$weather."'. Die Temperatur beträgt ".$temperatureInCelsius ."&deg;C, gefühlt wie " .$feelTemperature ."&deg;C. Die Windgeschwindigkeit beläuft sich auf " .$windSpeed ."m/s.";

		echo "<br/><br/>";

		echo "</div></div>";
	} else {
		echo "<div class=\"alert alert-danger\" role=\"alert\">Die Stadt konnte nicht gefunden werden. </div>";
	}
}

?>			
		</div>
	</div>

  </body>
</html>
