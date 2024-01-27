<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$api_key = '3db0ab40eef446bbb0ab40eef416bbb5';
$station_id = 'IALJAM4';

$api_url_current = "https://api.weather.com/v2/pws/observations/current?stationId=$station_id&format=json&units=m&apiKey=$api_key&numericPrecision=decimal";
$api_url_7days = "https://api.weather.com/v2/pws/dailysummary/7day?stationId=$station_id&format=json&units=m&apiKey=$api_key&numericPrecision=decimal";

// Fetch data from API
$json_data_current = file_get_contents($api_url_current);
if ($json_data_current === FALSE) {
  die('Failed to fetch current data');
}
$response_data_current = json_decode($json_data_current, true);

$json_data_7days = file_get_contents($api_url_7days);
if ($json_data_7days === FALSE) {
  die('Failed to fetch 7 days data');
}
$response_data_7days = json_decode($json_data_7days, true);






if (isset($response_data_current) && $response_data_current !== null) {
    $currentTemperature = $response_data_current['observations'][0]['metric']['temp'];
    $feelsLikeTemperature = $response_data_current['observations'][0]['metric']['windChill'];
    $humidity = $response_data_current['observations'][0]['humidity'];
    $winddir = $response_data_current['observations'][0]['winddir'];
    $windSpeed = $response_data_current['observations'][0]['metric']['windSpeed'];
    $windGust = $response_data_current['observations'][0]['metric']['windGust'];
    $rainRate = $response_data_current['observations'][0]['metric']['precipRate'];
    $rainToday = $response_data_current['observations'][0]['metric']['precipTotal'];
    $pressure = $response_data_current['observations'][0]['metric']['pressure'];


    // Get the index of the last day
    $lastDayIndex = count($response_data_7days['summaries']) - 1;


    // Get the data for the last day
    $lastDayData = $response_data_7days['summaries'][$lastDayIndex];

    // Access the temperature values for the last day
    $lastDayHighTemp = $lastDayData['metric']['tempHigh'];
    $lastDayLowTemp = $lastDayData['metric']['tempLow'];
    $highWindSpeed = $lastDayData['metric']['windspeedHigh'];
    $highGustSpeed = $lastDayData['metric']['windgustHigh'];
    $avgWindSpeed = $lastDayData['metric']['windspeedAvg'];
    $pressureMax = $lastDayData['metric']['pressureMax'];
    $pressureMin = $lastDayData['metric']['pressureMin'];

    // all data - rain - month


  } else {

    $currentTemperature = 'N/A';
    $feelsLikeTemperature = 'N/A';
    $humidity = 'N/A';
    $windSpeed = 'N/A';
    $windGust = 'N/A';
    $winddir = 'N/A';
    $rainRate = 'N/A';
    $rainToday = 'N/A';
    $lastDayHighTemp = 'N/A';
    $lastDayLowTemp = 'N/A';
    $highWindSpeed = 'N/A';
    $avgWindSpeed = 'N/A';
    $pressureMax = 'N/A';
    $pressureMin = 'N/A';


  }


  $sql = "INSERT INTO weatherData (precipRate)
  VALUES ($rainRate)";
  
  if ($conn->query($sql) === TRUE) {
      echo "";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
  


  // Initialize date range for daily data
$start_date = new DateTime("2024-01-09");
$today_date = new DateTime(); 
$end_date = ($today_date < new DateTime("2024-01-31")) ? $today_date : new DateTime("2024-01-31"); // Set end date to today's date or January 31, 2024, whichever is earlier

$total_rain = 0;

while ($start_date <= $end_date) {
  $date = $start_date->format("Ymd");
  $api_url_daily = "https://api.weather.com/v2/pws/history/daily?stationId=$station_id&format=json&units=m&date=$date&apiKey=$api_key&numericPrecision=decimal";
  $json_data_daily = file_get_contents($api_url_daily);

  if ($json_data_daily === FALSE) {
    echo "Failed to fetch data for $date\n";
  } else {
    $response_data_daily = json_decode($json_data_daily, true);

    // Check if the necessary data is available and is an array
    if (isset($response_data_daily['observations'][0]['metric']) && is_array($response_data_daily['observations'][0]['metric'])) {
      // Check if 'precipTotal' is set
      if (isset($response_data_daily['observations'][0]['metric']['precipTotal'])) {
        $daily_rain = $response_data_daily['observations'][0]['metric']['precipTotal'];
        $total_rain += $daily_rain;
      } else {
        echo "Rain data not available for $date\n";
      }
    } else {
      echo "Metric data not available for $date\n";
    }
  }
  $start_date->modify('+1 day');
}


  
// Initialize date range for daily data
$start_date = new DateTime("2024-01-09");
$today_date = new DateTime(); 
$end_date = ($today_date < new DateTime("2024-05-1")) ? $today_date : new DateTime("2024-05-1"); // Set end date to today's date or January 31, 2024, whichever is earlier
$total_rain_s = 0;

while ($start_date <= $end_date) {
  $date = $start_date->format("Ymd");
  $api_url_daily = "https://api.weather.com/v2/pws/history/daily?stationId=$station_id&format=json&units=m&date=$date&apiKey=$api_key&numericPrecision=decimal";
  $json_data_daily = file_get_contents($api_url_daily);

  if ($json_data_daily === FALSE) {
    echo "Failed to fetch data for $date\n";
  } else {
    $response_data_daily = json_decode($json_data_daily, true);

    // Check if the necessary data is available and is an array
    if (isset($response_data_daily['observations'][0]['metric']) && is_array($response_data_daily['observations'][0]['metric'])) {
      // Check if 'precipTotal' is set
      if (isset($response_data_daily['observations'][0]['metric']['precipTotal'])) {
        $daily_rain = $response_data_daily['observations'][0]['metric']['precipTotal'];
        $total_rain_s += $daily_rain;

      } else {
        echo "Rain data not available for $date\n";
      }
    } else {
      echo "Metric data not available for $date\n";
    }
  }
  $start_date->modify('+1 day');
}




  // Database configuration
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "pws";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT MAX(precipRate) AS maxRainRate FROM weatherdata";
  $result = $conn->query($sql);
  
  
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $HighRainRate = $row['maxRainRate'];
   

      
      
    }
  }
  $conn->close();

?>