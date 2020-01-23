<?php

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

function edizm($ID){
		$path="/1C/odata/standard.odata/Catalog_".urlencode("КлассификаторЕдиницИзмерения")."(guid'".$ID."')?\$format=json";
		$httpAns=httpRequest($path);
		$ed=json_decode($httpAns);
		return $ed->Description;
	}
/*************************************************************************************/
// Вывод на экран рецептуры. Возвращает массив [viewed] с GUID показанных рецептур  и массив [included] с GUID вложенных рецептур.

function viewRecipeByProdID($ID){
		
		$path="/1C/odata/standard.odata/Document_".urlencode("ОбщепитРецептура")."?\$format=json&\$filter=Номенклатура_Key%20eq%20guid'".$ID."'";
		$httpAns=httpRequest($path);
		$recipe=json_decode($httpAns);
//var_dump($recipe);
	
		$path="/1C/odata/standard.odata/Catalog_".urlencode("Номенклатура")."(guid'".$_GET["ProdID"]."')"."?\$format=json" ;
		$httpAns=httpRequest($path);
		$bludo=json_decode($httpAns);
//var_dump($bludo);


		foreach ($recipe->value as $value){
			echo "<div class='recipe'>";
			echo "<div class='recipeProp'>";
				echo "Рецептура № ".$value->Number." от ".$value->Date."</br>";
				echo "Наименование блюда: <h2>".$bludo->НаименованиеПолное."</h2>";
				echo "Выход блюда - ".$value->Выход." грамм.</br>";
			echo "</div>";
			echo "<div class='recipeCalc'>";
				$edizm=edizm($value->ЕдиницаИзмерения_Key);
				echo "Рецептура на: </br>";
				echo  "<input class='inputNum' type='number' size='1' onChange='recalc()' name='num' min='1' max='100' value='".$value->Количество."' >".$edizm."</input>";
				echo "</br> Укажите необходимое количество для пересчета </br>";
			echo "</div>";
			echo "<div style='clear:both;'></div>";
			echo "Технология приготовления:".$value->ТехнологияПриготовления."</br>";
			echo "<table>";
				echo "<tr>";
					echo "<th>№</th>";
					echo "<th>Продукт</th>";
					echo "<th>Брутто</th>";
					echo "<th>Нетто</th>";
					echo "<th>Выход</th>";
					echo "<th>Рецептура</th>";
				echo "</tr>";
			$i=1;	
			foreach ($value->Товары as $goods){
				$path="/1C/odata/standard.odata/Catalog_".urlencode("Номенклатура")."(guid'".$goods->Номенклатура_Key."')"."?\$format=json" ;
				$httpAns=httpRequest($path);
				$good=json_decode($httpAns);
				echo "<tr>";
					echo "<td id='tb_num'>".$i."</td>";
					echo "<td id='tb_name'>".$good->НаименованиеПолное."</td>";
					echo "<td id='tb_brutto'>".number_format($goods->Количество,3)."</td>";
					echo "<td id='tb_netto'>".number_format($goods->КоличествоНетто,3)."</td>";
					echo "<td id='tb_out'>".number_format($goods->КоличествоВыход,3)."</td>";
					if ($goods->Рецептура_Key<>'00000000-0000-0000-0000-000000000000'){
						$returnID["included"][]=$goods->Рецептура_Key;
						echo "<td id='tb_recipe'>Есть</td>";
					} else {
						echo "<td id='tb_recipe'></td>";
					}
				echo "</tr>";
				$i++;
			}
			echo "</table>";
			echo "</div>";
			$returnID["viewed"][] = $value->Ref_Key;
			
		}
	return $returnID;
}	
function viewRecipeByID($ID){
		$path="/1C/odata/standard.odata/Document_".urlencode("ОбщепитРецептура")."(guid'".$ID."')?\$format=json" ;
		$httpAns=httpRequest($path);
		$recipe=json_decode($httpAns);
//var_dump($recipe);
		$path="/1C/odata/standard.odata/Catalog_".urlencode("Номенклатура")."(guid'".$recipe->Номенклатура_Key."')?\$format=json" ;
		$httpAns=httpRequest($path);
		$bludo=json_decode($httpAns);
//var_dump($httpAns);
		echo "<div class='recipe'>";
		echo "<div class='recipeProp'>";
			echo "Рецептура № ".$recipe->Number." от ".$recipe->Date."</br>";
			echo "Наименование блюда: <h2>".$bludo->НаименованиеПолное."</h2>";
			echo "Расчитано на: ".$recipe->Количество."</br>";
			echo "Выход блюда - ".$recipe->Выход." грамм.</br>";
		echo "</div>";
		echo "<div class='recipeCalc'>";
		echo "</div>";
		echo "<div style='clear:both;'></div>";
		echo "Технология приготовления:".$recipe->ТехнологияПриготовления."</br>";
		echo "<table>";
			echo "<tr>";
				echo "<th>№</th>";
				echo "<th>Продукт</th>";
				echo "<th>Брутто</th>";
				echo "<th>Нетто</th>";
				echo "<th>Выход</th>";
				echo "<th>Рецептура</th>";
			echo "</tr>";
		$i=1;	
		foreach ($recipe->Товары as $goods){
			//echo $goods->Номенклатура_Key;
			$path="/1C/odata/standard.odata/Catalog_".urlencode("Номенклатура")."(guid'".$goods->Номенклатура_Key."')?\$format=json" ;
			$httpAns=httpRequest($path);
			$good=json_decode($httpAns);
			echo "<tr>";
				echo "<td id='tb_num'>".$i."</td>";
				echo "<td id='tb_name'>".$good->НаименованиеПолное."</td>";
				echo "<td id='tb_brutto'>".number_format($goods->Количество,3)."</td>";
				echo "<td id='tb_netto'>".number_format($goods->КоличествоНетто,3)."</td>";
				echo "<td id='tb_out'>".number_format($goods->КоличествоВыход,3)."</td>";
				if ($goods->Рецептура_Key<>'00000000-0000-0000-0000-000000000000'){
					$returnID["included"][]=$goods->Рецептура_Key;
					echo "<td id='tb_recipe'>Есть</td>";
				} else {
					echo "<td id='tb_recipe'></td>";
				}
			echo "</tr>";
			$i++;
		}
		echo "</table>";
		echo "</div>";
		$returnID["viewed"][] = $recipe->Ref_Key;
		
	
	
	return $returnID;
}


?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Рецептура</title>
<style>
	.navi {
                width: 100px;
                height: 100px;
                border: solid grey 1px;
                position: fixed;
                border-radius: 10px;
                right: 10px;
                cursor: pointer;
				z-index: 100;
				background-color: white;
            }
	.recipe {
		margin: 20px auto;
		position: relative;
		width:920px;
		box-shadow: 0 0 30px rgba(0,0,0,0.5);
		padding: 20px;
	}
	.recipeProp {
		width:40%;
		margin: 5%;
		float:left;
	}
	.recipeCalc {
		width:40%;
		margin: 5%;
		float:right;
		text-align:center;
		font-size: 14pt;
	}
	.inputNum {
		font-size: 20pt;
		border: none;
	}
	table {
		margin: auto;
	}
	th {
		background-color: grey;
		color: white;
	}
	#tb_num {
		width: 5%;
		text-align:center;
		border-bottom: 1px dotted grey;
	}
	#tb_name {
		width:45%;
		border-bottom: 1px dotted grey;
	}
	#tb_brutto {
		width:15%;
		border-bottom: 1px dotted grey;
		text-align:right;		
	}
	#tb_netto {
		width:15%;
		border-bottom: 1px dotted grey;
		text-align:right;
	}
	#tb_out {
		width:15%;
		border-bottom: 1px dotted grey;
		text-align:right;
	}
	#tb_recipe {
		width:30%;
		border-bottom: 1px dotted grey;
		text-align:center;
	}
</style>
<script>
	function recalc(){
		alert ("Changed");
	}
</script>
</head>

<body>
	<div class="navi" onClick="history.back()"
     style="
                background-image: url('Images/x.png');
                top: 5px;">

</div>


<div class="navi" onclick="window.scrollBy(0,-200)"
         style="background-image: url('Images/row_up.png');
                top: 450px;
         ">
</div>

<div class="navi" onclick="window.scrollBy(0,200)"
        style=" background-image: url('Images/row_down.png');
                top: 600px;
        ">
</div> 
<?php
	$viewed=[];
	$a=viewRecipeByProdID($_GET["ProdID"]);
//var_dump($a);
	$viewed=array_merge($viewed,$a["viewed"]);
//var_dump($viewed);
	foreach ($a["included"] as $guid) {
		$test_viewed=true;
		foreach ($viewed as $viewed_guid){
			if ($guid==$viewed_guid) $test_viewed=false;
		}
	
		if($test_viewed==true){
			$n=viewRecipeByID($guid);
			$viewed=array_merge($viewed,$n["viewed"]);
		}	
//var_dump($test_viewed);
	}
	
?>
</body>
</html>