<?php

// upload_xml_recipe_to_restart.php

// Функция загрузки рецептур из файла exchange_1c/recipe.xml в базу РестАрт
include ("lib/db_Restart.php");
function load_recipes_from_xml ($kassa) {
	

	if (file_exists('recipe.xml')) {
		$recipe_xml=simplexml_load_file('recipe.xml');
		$namespaces = $recipe_xml->getNameSpaces( true );
		$data=$recipe_xml->children($namespaces['V8Exch']);
		$doc=$data->children($namespaces['v8']);    

		

		// Запись в базу данных РестАрта

		// Инициализация базы
		
$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы
$db= new orange\db_Restart ($config,$kassa);

		//Формирование SQL запроса на очищение базы
		$tsql= "TRUNCATE TABLE [dbo].[tb_RecItem]";
		$getResults= $db->query($tsql);

		

		$tsql= "TRUNCATE TABLE [dbo].[tb_Recipe]";
		$getResults= $db->query($tsql);

		


		// Добавление записей в базу РестАрт
		$i=1;
		foreach ($doc->{'DocumentObject.ОбщепитРецептура'} as $arr_recipe) {
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
					'".$arr_recipe->Ref."',
					'1',
					'".$arr_recipe->Number."',
					'".substr_replace($arr_recipe->Date,'20',0,2)."',
					'".substr_replace($arr_recipe->Date,'20',0,2)."',
					'".$arr_recipe->Posted."',
					'".$arr_recipe->Организация."',
					'00000000-0000-0000-0000-000000000000',
					'".substr_replace($arr_recipe->ДатаНачала,'20',0,2)."',
					'".substr_replace($arr_recipe->ДатаКонца,'20',0,2)."',
					'".$arr_recipe->Number."',
					'".$arr_recipe->Номенклатура."',
					'".$arr_recipe->Количество."',
					'',
					'".$arr_recipe->ЕдиницаИзмерения."',
					'',
					'".$arr_recipe->Выход."',
					'1',
					'',
					'".$arr_recipe->ТехнологияПриготовления."',
					'{\"Оформление\":\"".$arr_recipe->ТребованияКОформлению."\",\"ВнешнийВид\":\"".$arr_recipe->ВнешнийВид."\",\"Цвет\":".$arr_recipe->Цвет."\",\"Консистенция\":\"".$arr_recipe->Консистенция."\",\"ВкусИЗапах\":\"".$arr_recipe->ВкусИЗапах."\"}',
					'".$arr_recipe->Комментарий."'
					);";
			
			$getResults= $db->query($tsql);

			
			$Line_Number=1;
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
						'".$arr_recipe->Ref."',
						'".$Line_Number."',
						(SELECT [dbo].[tb_Product].[Name] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура."'),
						'".$recipe_good->Номенклатура."',
						'".$recipe_good->Количество."',
						'".$recipe_good->КоличествоНетто."',
						'".$recipe_good->КоличествоВыход."',
						(SELECT [dbo].[tb_Product].[Unit] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура."'),
						(SELECT [dbo].[tb_Product].[UnitID] FROM [dbo].[tb_Product] WHERE [dbo].[tb_Product].[ObjID]='".$recipe_good->Номенклатура."'),
						'".$recipe_good->Рецептура."',
						'".$recipe_good->Специя."'
						);";
				$getResults= $db->query($tsql_goods);
				
				
				$Line_Number++;
			}
					$i++;
		}


		
		echo "Импортировано в РестАрт ".$i."  рецептур";   
	} else {
	    exit('Failed to open recipe.xml.');
	}
}
// Конец функции load_recipes_from_xml ()

load_recipes_from_xml (0); // загрузка данных из файла /exchange_1c/recipe.xml в базу РестАрт
echo 'Данные загружены в кассу раздачи';
load_recipes_from_xml (1); // загрузка данных из файла /exchange_1c/recipe.xml в базу РестАрт
echo 'Данные загружены в кассу бара';

?>