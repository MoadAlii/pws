<?php
$api_key = '23999150bfda4c77999150bfda4c771e';
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


?>
