<?php

//назначаем переменные
$link = 'http://api.openweathermap.org/data/2.5/forecast/';
$secretKey = 'ca284cfc426e0044aafc09994988e130';
$city = 'Khabarovsk';
$units = 'metric';
$lang = 'ru';
$weatherInfo = [];
$filename = "weather.txt";

//получаем по ссылке данные
$url = "$link?q=$city&units=$units&lang=$lang&appid=$secretKey";
$urldata = file_get_contents($url);

//проверка - если данные не пришли, то берем из кэша
if (empty($urldata)) {
    $data = file_get_contents($filename);
    $weatherInfo = json_decode($data, true) or exit('Ошибка декодирования json');
} else {

//открываем или создаем файл, записываем туда закодированные данные
    $fd = fopen($filename, 'w+') or die('не удалось создать файл');
    file_put_contents($filename, $urldata);
    fclose($fd);
    $data = file_get_contents($filename);
    $weatherInfo [] = json_decode($data, TRUE);
}

// сохраняем нужные данные в переменных, если они пришли
$temperature = (!empty ($weatherInfo[0]['list'][0]['main']['temp'])) ? round($weatherInfo[0]['list'][0]['main']['temp']) : 'Не удалось получить температуру.';
$weather = (!empty ($weatherInfo[0]['list'][0]['weather'][0]['description'])) ? $weatherInfo[0]['list'][0]['weather'][0]['description'] : 'Не удалось получить погоду.';
$iconId = (!empty ($weatherInfo[0]['list'][0]['weather'][0]['icon'])) ? $weatherInfo[0]['list'][0]['weather'][0]['icon'] : 'Не удалось получить изображение.';
$iconLink = "http://openweathermap.org/img/w/$iconId.png";

//подставляем минус или плюс в зависимости от температуры
if ($temperature > 0) {
    $temperature = "+" . $temperature;

} elseif ($temperature < 0) {
    $temperature = "-" . $temperature;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Домашняя работа</title>
</head>
<body>
<table>
    <tr>
        <td>
            <span style="font-size:40pt;"><?php echo $temperature; ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $weather; ?>
        </td>
        <td>
            <img src="<?php print ($iconLink); ?>">
        </td>
    </tr>
</table>
</body>
</html>