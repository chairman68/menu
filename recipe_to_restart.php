<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Импорт рецептур в РестАрт</title>
</head>

<body>


<?php /* Скрипт загрузки рецептур из 1С Общепит в РестАрт */
//include("config.php");
$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

// Выгрузка рецептур из 1с общепит на сервер

function httpRequest($path){
	
	$fp = @fsockopen($config->db_1c_connection->host, 8080, $errno, $errstr, 10); // Параметры подключения в config.php
	if (!$fp)
	{
		die($errstr.':'.$errno);
		echo "Что-то пошло не так!";
	}
	else
	{
		$out  = "GET $path HTTP/1.0\r\n";
		$out .= "Host: $host\r\n";
		//авторизируемся
		$out .= "Authorization: Basic " . base64_encode("$config->1c_connection->user:$config->1c_connection->password") . "\r\n";
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

// Формируем http запрос через odata
$path="/1C/odata/standard.odata/Document_".urlencode("ОбщепитРецептура")."?\$format=json" ;
		$httpAns=httpRequest($path);
		$recipe=json_decode($httpAns);
// В переменной $recipe - выгруженные рецептуры



var_dump($recipe);

/*****************  Пример структуры объекта $recipe ***********************************************

object(stdClass)#1 (2) {
["odata.metadata"]=> string(100) "http://192.168.1.47:8080/1C/odata/standard.odata/$metadata#Document_ОбщепитРецептура" 
["value"]=> array(846) { 
	[0]=> object(stdClass)#2 (33) {
		["Ref_Key"]=> string(36) "c4a21c02-6e8b-11e6-8022-00155d012807"
		["DataVersion"]=> string(12) "AAAAAQAAApE=" 
		["DeletionMark"]=> bool(false) 
		["Number"]=> string(13) "МС00-000232" 
		["Date"]=> string(19) "2016-08-01T23:59:59" 
		["Posted"]=> bool(false) 
		["ВидОперации"]=> string(26) "Приготовление" 
		["Организация_Key"]=> string(36) "8b085dac-8815-11e3-93ee-00155d012805" 
		["Ответственный_Key"]=> string(36) "4fd94945-8813-11e3-93ee-00155d012805" 
		["Комментарий"]=> string(0) "" 
		["Номенклатура_Key"]=> string(36) "ff6cb637-c4af-4982-aa51-e788238fb4d7" 
		["ЕдиницаИзмерения_Key"]=> string(36) "effc5f09-87ea-11e3-93ee-00155d012805" 
		["Коэффициент"]=> int(1) 
		["Количество"]=> int(10) 
		["НомерРецептуры"]=> string(0) "" 
		["Основная"]=> bool(false) 
		["Выход"]=> string(2) "80" 
		["ТехнологияПриготовления"]=> string(333) "Филе пропускают через мясорубку, добавляют нарубленную зелень, сырое яйцо, сыр, чеснок, специи. Формируют шарики по 90гр, панируют в сухарях, запекают в жаровочном шкафу до готовности." 
		["ДокументОснование_Key"]=> string(36) "00000000-0000-0000-0000-000000000000" 
		["ДатаНачала"]=> string(19) "2016-08-01T00:00:00" 
		["ДатаКонца"]=> string(19) "0001-01-01T00:00:00" 
		["ФормулаРасчетаКалорийности"]=> string(0) "" 
		["СпособРасчетаКалорийности"]=> string(0) "" 
		["ОбластьПрименения"]=> string(0) "" 
		["ТребованияКОформлению"]=> string(0) "" 
		["ВнешнийВид"]=> string(0) "" 
		["Цвет"]=> string(0) "" 
		["Консистенция"]=> string(0) "" 
		["ВкусИЗапах"]=> string(0) "" 
		["ВыходВес"]=> int(0) 
		["Товары"]=> array(1) {
		[0]=> object(stdClass)#3 (19) {
			["Ref_Key"]=> string(36) "c4a21c02-6e8b-11e6-8022-00155d012807" 
			["LineNumber"]=> string(1) "1" 
			["Номенклатура_Key"]=> string(36) "92ae9c30-882d-11e3-93ee-00155d012805" 
			["ЕдиницаИзмерения_Key"]=> string(36) "effc5f07-87ea-11e3-93ee-00155d012805" 
			["Коэффициент"]=> int(1) 
			["Количество"]=> float(0.77) 
			["КоличествоНетто"]=> float(0.7) 
			["КоличествоВыход"]=> float(0.7) 
			["КоличествоВыходВес"]=> int(0) 
			["Рецептура_Key"]=> string(36) "00000000-0000-0000-0000-000000000000" 
			["Специя"]=> bool(false) 
			["ЗапретитьЗамены"]=> bool(false) 
			["Замена_Key"]=> string(36) "00000000-0000-0000-0000-000000000000" 
			["КоэффициентЗамены"]=> int(0) 
			["ПроцентПотерьПриХолоднойОбработке"]=> float(9.09) 
			["ПроцентПотерьПриГорячейОбработке"]=> int(0) 
			["ПроцентСебестоимости"]=> int(0) 
			["Цена"]=> int(0) 
			["Сумма"]=> int(0) 
			} 
	} 
	["Организация@navigationLinkUrl"]=> string(108) "Document_ОбщепитРецептура(guid'c4a21c02-6e8b-11e6-8022-00155d012807')/Организация" 
	["Номенклатура@navigationLinkUrl"]=> string(110) "Document_ОбщепитРецептура(guid'c4a21c02-6e8b-11e6-8022-00155d012807')/Номенклатура" 
} 
***************************************************************************************************************************************/

?>

// Запись в базу данных РестАрта

// Инициализация базы
function FormatErrors( $errors ){
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )   {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}


//Подключение к БД. Параметры в $config
$conn = sqlsrv_connect($config->db_connect->serverName, $config->db_connect->connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 

//Формирование SQL запроса на очищение базы
$tsql= "TRUNCATE TABLE [dbo].[tb_RecItem]";
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));

$tsql= "TRUNCATE TABLE [dbo].[tb_Recipe]";
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));


// Добавление записей в базу РестАрт
$i=1;
foreach ($recipe->value as $arr_recipe) {
	//echo $i;
	//if ($i==450) var_dump($arr_recipe);
	$tsql= "INSERT INTO [dbo].[tb_Recipe] (
			[dbo].[tb_Recipe].[ObjID],
			[dbo].[tb_Recipe].[ObjActive],
			[dbo].[tb_Recipe].[ExtrnCode],
			[dbo].[tb_Recipe].[ObjTS],
			[dbo].[tb_Recipe].[ObjCrtnTS],
			[dbo].[tb_Recipe].[Posted],
			[dbo].[tb_Recipe].[OrgID],
			[dbo].[tb_Recipe].[SubunitID],
			[dbo].[tb_Recipe].[BegDate],
			[dbo].[tb_Recipe].[EndDate],
			[dbo].[tb_Recipe].[Number],
			[dbo].[tb_Recipe].[ProdID],
			[dbo].[tb_Recipe].[Quantity],
			[dbo].[tb_Recipe].[UnitName],
			[dbo].[tb_Recipe].[UnitID],
			[dbo].[tb_Recipe].[Image],
			[dbo].[tb_Recipe].[OutPut],
			[dbo].[tb_Recipe].[Main],
			[dbo].[tb_Recipe].[CookingTime],
			[dbo].[tb_Recipe].[PrepTechnology],
			[dbo].[tb_Recipe].[ExteriorReqs],
			[dbo].[tb_Recipe].[Comment]
			)
			VALUES (
			'".$arr_recipe->Ref_Key."',
			'1',
			'".$arr_recipe->Number."',
			'".substr_replace($arr_recipe->Date,'20',0,2)."',
			'".substr_replace($arr_recipe->Date,'20',0,2)."',
			'".$arr_recipe->Posted."',
			'".$arr_recipe->Организация_Key."',
			'00000000-0000-0000-0000-000000000000',
			'".substr_replace($arr_recipe->ДатаНачала,'20',0,2)."',
			'".substr_replace($arr_recipe->ДатаКонца,'20',0,2)."',
			'".$arr_recipe->Number."',
			'".$arr_recipe->Номенклатура_Key."',
			'".$arr_recipe->Количество."',
			'',
			'".$arr_recipe->ЕдиницаИзмерения_Key."',
			'',
			'".$arr_recipe->Выход."',
			'1',
			'',
			'".$arr_recipe->ТехнологияПриготовления."',
			'{\"Оформление\":\"".$arr_recipe->ТребованияКОформлению."\",\"ВнешнийВид\":\"".$arr_recipe->ВнешнийВид."\",\"Цвет\":".$arr_recipe->Цвет."\",\"Консистенция\":\"".$arr_recipe->Консистенция."\",\"ВкусИЗапах\":\"".$arr_recipe->ВкусИЗапах."\"}',
			'".$arr_recipe->Комментарий."'
			);";
	
	$getResults= sqlsrv_query($conn, $tsql);

	if ($getResults == FALSE) {
	echo "Ошибка при обращении к таблице tb_Recipe <br/>";	
		die(FormatErrors(sqlsrv_errors()));
	}
	foreach ($arr_recipe->Товары as $recipe_good) {
		$tsql_goods= "INSERT INTO [dbo].[tb_RecItem] (
			  	[dbo].[tb_RecItem].[LinkID],
				[dbo].[tb_RecItem].[Pos],
				[dbo].[tb_RecItem].[ProdName],
				[dbo].[tb_RecItem].[ProdID],
				[dbo].[tb_RecItem].[QntAll],
				[dbo].[tb_RecItem].[QntNet],
				[dbo].[tb_RecItem].[QntOut],
				[dbo].[tb_RecItem].[UnitName],
				[dbo].[tb_RecItem].[UnitID],
				[dbo].[tb_RecItem].[RecipeID],
				[dbo].[tb_RecItem].[Spice]
				)
				VALUES (
				'".$recipe_good->Ref_Key."',
				'".$recipe_good->Line_Number."',
				(SELECT [dbo].[tb_Product].[Name] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура_Key."'),
				'".$recipe_good->Номенклатура_Key."',
				'".$recipe_good->Количество."',
				'".$recipe_good->КоличествоНетто."',
				'".$recipe_good->КоличествоВыход."',
				(SELECT [dbo].[tb_Product].[Unit] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура_Key."'),
				(SELECT [dbo].[tb_Product].[UnitID] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура_Key."'),
				'".$recipe_good->Рецептура_Key."',
				'".$recipe_good->Специя."'
				);";
		$getResults= sqlsrv_query($conn, $tsql_goods);

	if ($getResults == FALSE) {
		echo "Ошибка при обращении к таблице tb_RecItem <br/>";	
		die(FormatErrors(sqlsrv_errors()));
	}
	}
			$i++;
}


sqlsrv_free_stmt($getResults);
echo "Импортировано в РестАрт ".$i."  рецептур";
?>


</body>
</html>