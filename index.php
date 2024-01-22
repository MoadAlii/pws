<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="20">
  <link rel="shortcut icon" href="/assets/images/logow.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.csshttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/style.css">
  <title>ShafaBadranPWS</title>
</head>

<body>
  <style>
    body {
      background-image: url('assets/images/wallpaper.jpg');
    }
  </style>

  <?php
  include('api.php');

  global $api_key, $station_id;

  if (isset($response_data_current) && $response_data_current !== null) {
    $currentTemperature = $response_data_current['observations'][0]['metric']['temp'];
    $feelsLikeTemperature = $response_data_current['observations'][0]['metric']['heatIndex'];
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
  }
  ?>



  <div class="container-fluid ">

    <div class="container location">

      <h4 class="location-title">
        North Amman, Al-koom
      </h4>
      <i class="fa-solid fa-earth-americas location-icon"></i>
    </div>


    <div class="temp-container">

      <div class="temp-h" style="margin-top: 25px; margin-bottom: 25px; place-content: center !important;">
        <p class="humidity-p">Temperature</p>
        <h1 class="temp-p"><?php echo $currentTemperature; ?>°</h1>
        <div class="line2"></div>
        <p class="humidity-p">Feels like</p>
        <h1 class="temp-p"><?php echo $feelsLikeTemperature ?>°</h1>
      </div>
      <div class="humi-wind">
        <p class="wind-p"><i style="margin-right: 5px;" class="fa-solid fa-droplet"></i><?php echo $humidity; ?> %</p>

        <?php
        function degreesToCardinal($degrees)
        {
          $cardinals = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW');
          $index = round($degrees / 22.5);
          return $cardinals[$index % 16];
        }

        // Output the wind direction and speed
        echo '<p class="wind-p"><i style="margin-right: 5px;" class="fas fa-wind"></i>' . degreesToCardinal($winddir) . ' ' . $windSpeed . ' km/h</p>';
        ?>
        <p class="wind-p"><i style="margin-right: 5px;" class="fa-solid fa-wind"></i>Gust <?php echo $windGust; ?> km/h</p>
        <p class="wind-p"><i style="margin-right: 5px;" class="fa-solid fa-cloud-showers-water"></i><?php echo $rainRate; ?> mm/h</p>
        <p class="wind-p"><i style="margin-right: 5px;" class="fa-solid fa-gauge-high"></i><?php echo $pressure; ?> HPa</p>
      </div>
    </div>


    <div class="main-container ">
      <div class="data-tabel">

        <div class="rain-data">
          <p class="rain-p">High Temperature</p>
          <p class="rain-p2"><?php echo $lastDayHighTemp;  ?>°</p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">Low Temperature</p>
          <p class="rain-p2"><?php echo $lastDayLowTemp  ?> °</p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">High Wind Speed</p>
          <p class="rain-p2"><?php echo $highWindSpeed ?> km/h </p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">High Gust Speed</p>
          <p class="rain-p2"><?php echo $highGustSpeed ?> km/h </p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">Average Wind Speed</p>
          <p class="rain-p2"><?php echo $avgWindSpeed ?> km/h </p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">High Pressure</p>
          <p class="rain-p2"><?php echo $pressureMax ?> </p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p class="rain-p">Low Pressure</p>
          <p class="rain-p2"><?php echo $pressureMin ?> </p>
        </div>






      </div>
    </div>

    <div class="main-container ">
      <div class="data-tabel">

        <div class="rain-data">
          <p style="color: #040a06 !important;" class="rain-p"><i style="color: #040a06 !important;" class="fa-solid fa-glass-water weather-icon"></i>Rain Today</p>
          <p style="color: #040a06 !important;" class="rain-p2"><?php echo $rainToday; ?> mm</p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p style="color: #040a06 !important;" class="rain-p"><i style="color: #040a06 !important;" class="fa-solid fa-glass-water weather-icon"></i>Rain Month</p>
          <p style="color: #040a06 !important;" class="rain-p2"><?php echo $total_rain; ?> mm</p>
        </div>

        <div class="v-line"></div>

        <div class="rain-data">
          <p style="color: #040a06 !important;" class="rain-p"><i style="color: #040a06 !important;" class="fa-solid fa-glass-water weather-icon"></i>Rain Season</p>
          <p style="color: #040a06 !important;" class="wind-p"><?php echo $total_rain_s + 150 ?> mm</p>
        </div>




      </div>
    </div>

    <div class="main-container">
      <h5 style="color: #040a06; font-weight: 500;">Wather station History</h5>
      <div class="container mt-3">
        <button type="button" data-days="2" class="btn btn-history">2 Days</button>
        <button type="button" data-days="2" class="btn btn-history">3 Days</button>
        <button type="button" data-days="2" class="btn btn-history">4 Days</button>
        <button type="button" data-days="2" class="btn btn-history">5 Days</button>
        <button type="button" data-days="2" class="btn btn-history">Week</button>
        <button type="button" data-days="2" class="btn btn-history">Last Month</button>
        <button type="button" data-days="2" class="btn btn-history">Season</button>
      </div>

      <div class="custom_table table-container mt-4">
        <table class="w-100">
          <thead>
            <tr>
              <th class="data-header">Statistic</th>
              <th class="data-header">Value</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>



  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    // This function updates the table with the weather data
function updateTable(data) {
    const tableBody = document.querySelector('.table-container tbody');
    tableBody.innerHTML = `
        <tr><td>Highest Max Temperature</td><td>${data.highestMaxTemp}</td></tr>
        <tr><td>Lowest Max Temperature</td><td>${data.lowestMaxTemp}</td></tr>
        <tr><td>Highest Min Temperature</td><td>${data.highestMinTemp}</td></tr>
        <tr><td>Lowest Min Temperature</td><td>${data.lowestMinTemp}</td></tr>
        <tr><td>Average Temperature</td><td>${data.averageTemp}</td></tr>
        <tr><td>Highest Wind Speed</td><td>${data.highestWindSpeed}</td></tr>
        <tr><td>Highest Wind Gust Speed</td><td>${data.highestWindGustSpeed}</td></tr>
        <tr><td>Average Wind Speed</td><td>${data.averageWindSpeed}</td></tr>
        <tr><td>Rain</td><td>${data.rain}</td></tr>
        <tr><td>Highest Rain Rating</td><td>${data.highestRainRating}</td></tr>
    `;
}

// Sample data for demonstration
const weatherData = {
    highestMaxTemp: 30,
    lowestMaxTemp: 10,
    highestMinTemp: 5,
    lowestMinTemp: -5,
    averageTemp: 20,
    highestWindSpeed: 40,
    highestWindGustSpeed: 50,
    averageWindSpeed: 30,
    rain: 10,
    highestRainRating: 5
};

// Adding event listeners to buttons
document.querySelectorAll('.btn-history').forEach(button => {
    button.addEventListener('click', function() {
        updateTable(weatherData); // Update the table with the weather data
    });
}); 
  </script>

  <!-- 
        highestMaxTemp: 30,
        lowestMaxTemp: 10,
        highestMinTemp: 5,
        lowestMinTemp: -5,
        averageTemp: 20,
        highestWindSpeed: 40,
        highestWindGustSpeed: 50,
        averageWindSpeed: 30,
        rain: 10,
        highestRainRating: 5 -->
</body>

</html>