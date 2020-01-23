<?php
function httpRequest($resourceType,$resource,$cond,$filter){
	$user="1";
	$password="123";
	$host="192.168.1.47";
	
	$path="/1C/odata/standard.odata/".$resourceType."_".$resource.$cond."?$format=json" ;
	if ($filter<>"") $path=."&$filter=".$filter;
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
		fwrite($fp, $out.$data);
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
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>REST запрос</title>
</head>

<body>
<?php
$httpAns=httpRequest("Document",urlencode("ОбщепитРецептура"),"(guid'c4a21c02-6e8b-11e6-8022-00155d012807')","");
$reciept=json_decode($httpAns);
$httpAns=httpRequest("Catalog",urlencode("Номенклатура"),"","Ref_Key eq 'ff6cb637-c4af-4982-aa51-e788238fb4d7'");
$bludo=json_decode($httpAns);
echo "Наименование блюда: ".$bludo->НаименованиеПолное."</br>";
 var_dump($bludo);

echo "Технология приготовления:".$reciept->ТехнологияПриготовления."</br>";
foreach ($reciept->Товары as $goods){
	echo $goods->Номенклатура_Key;
	$httpAns=httpRequest("Catalog",urlencode("Номенклатура"),"(guid'".$goods->Номенклатура_Key."')","");
	$good=json_decode($httpAns);
	echo $good->НаименованиеПолное."</br>";
//	var_dump($good);
}
?>
</body>
</html>