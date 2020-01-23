<?php
// Библиотека функций доступа к 1С через интерфейс Odata
// lib_1c_odata.php
//*********************************************************
// Функция HTTP запроса к 1С
// Аргумент - строка запроса
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
// Обороты по счету
//*
function turnoversByAccount($beginDate,$endDate,$account){
	global $chart_of_accounts;
	$sum=array ('All' =>array ('Cr'=>0,'Dr'=>0));
	foreach ($chart_of_accounts->value as $value){
		if ($value->КодБыстрогоВыбора==$account) {
			$account_key=$value->Ref_Key;
		}
	}
	$path="/1C/odata/standard.odata/AccountingRegister_".urlencode("Хозрасчетный")."/Turnovers(StartPeriod=datetime'".$beginDate."',%20EndPeriod=datetime'".$endDate."',%20AccountCondition=Account_Key%20eq%20guid'".$account_key."')?\$filter=".urldecode("Организация_Key")."%20eq%20guid'387ebe13-3a57-11e4-93f9-00155d012805'\&\$format=json"; 

	$httpAns=httpRequest($path);
	$turnover=json_decode($httpAns);
	
	
	
	foreach ($turnover->value as $value) {
		if ($value->ExtDimension1<>'') {
			if (substr_count($value->ExtDimension1_Type,'StandardODATA.Catalog_')<>0){
				foreach ($dim[] as $catalog_dim){
					if ($catalog_dim)
					$path="/1C/odata/standard.odata/Catalog_".urlencode(str_replace('StandardODATA.Catalog_','',$value->ExtDimension1_Type))."?\$filter=Ref_Key%20eq%20guid'".$value->ExtDimension1."'&\$format=json"; 
					$httpAns=httpRequest($path);
					$dim1=json_decode($httpAns);
					//var_dump($dim1);
					echo $path."</br>".$dim1->value->Description;
				}	
			$sum[$dim1->value->Description][Cr]=$sum[$dim1->value->Description][Cr]+$value->СуммаTurnoverCr;
			$sum[$dim1->value->Description][Dr]=$sum[$dim1->value->Description][Dr]+$value->СуммаTurnoverDr;
			}
		}		
		$sum[All][Cr]=$sum[All][Cr]+$value->СуммаTurnoverCr;
		$sum[All][Dr]=$sum[All][Dr]+$value->СуммаTurnoverDr;
	}
var_dump($sum);	
return $sum;
}
//*/

$path="/1C/odata/standard.odata/ChartOfAccounts_".urlencode("Хозрасчетный")."?\$format=json";
$httpAns=httpRequest($path);
$chart_of_accounts=json_decode($httpAns);

?>
