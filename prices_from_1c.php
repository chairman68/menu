<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Импорт цен из 1с</title>
</head>

<body>


<?php /* Скрипт выгрузки цен из 1С Общепит */

// Выгрузка ЦЕН из 1с общепит на сервер

function httpRequest($path){
	$user="1";
	$password="123";
	$host="192.168.1.47";
	$fp = @fsockopen($host, 8080, $errno, $errstr, 10);
	if (!$fp)
	{
		die($errstr.':'.$errno);
	}
	else
	{
		$out  = "GET $path HTTP/1.0\r\n";
		$out .= "Host: $host\r\n";
		//авторизируемся
		$out .= "Authorization: Basic " . base64_encode("$user:$password") . "\r\n";
		$out .= "Connection: Close\r\n\r\n";

		//посылаем данные
		fwrite($fp, $out);
		$headers='';
		//читаем заголовки
		while ($str = trim(fgets($fp, 10000)))
		$headers .= "$str\n";
		$body='';
	 
		//читаем ответ
		while (!feof($fp))
		$body.= fgets($fp, 10000);
		//закрываем сокет
		fclose($fp);
		return $body;
	}
}

// Формируем http запрос через odata
$path="/1C/odata/standard.odata/InformationRegister_".urlencode("ЦеныНоменклатуры")."?\$format=json" ;

//$httpAns=httpRequest($path);
//$recipe=json_decode($httpAns);
$price=httpRequest($path);
// В переменной $recipe - выгруженные рецептуры


var_dump($price);
 
//var_dump($recipe);
    ?>
</body>
</html>
    