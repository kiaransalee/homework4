<?php

$secretKey = 'ca284cfc426e0044aafc09994988e130';
$city = 'Khabarovsk';
$units = 'metric';
$lang = 'ru';
$weatherInfo = [];
$filename = "weather.txt";
$urldata = NULL;
$url = NULL;

$url = "http://api.openweathermap.org/data/2.5/forecast/?q=$city&units=$units&lang=$lang&appid=$secretKey";
$urldata = file_get_contents($url);


if (empty($urldata)) {
    $data = file_get_contents($filename);
    $weatherInfo [] = json_decode($data, TRUE);
} else {

    $fd = fopen($filename, 'w+') or die("не удалось создать файл");
    file_put_contents($filename, $urldata);
    fclose($fd);
    $data = file_get_contents($filename);
    $weatherInfo [] = json_decode($data, TRUE);
}

$temperature = round($weatherInfo[0]['list'][0]['main']['temp']);
$weather = $weatherInfo[0]['list'][0]['weather'][0]['description'];
$iconId = $weatherInfo[0]['list'][0]['weather'][0]['icon'];
$iconLink = "http://openweathermap.org/img/w/$iconId.png";

if ($temperature > 0) {
    $temperature = "+" . $temperature;

} elseif ($temperature < 0) {
    $temperature = "-" . $temperature;
}

echo "<h1>" . $temperature . "</h1>";
echo $weather;
echo "<img src = '$iconLink'>";

?>