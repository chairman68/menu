<?php
function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}

$serverName = "CASH\RESTART";
$connectionOptions = array(
    "Database" => "CAFE",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);

//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 

/*************************************************************************************/
// Вывод на экран рецептуры. Возвращает массив [viewed] с GUID показанных рецептур  и массив [included] с GUID вложенных рецептур.

function viewRecipeByProdID($ID){
	global $conn;
	$tsql= "SELECT [dbo].[tb_Recipe].[ObjID]
				  ,[dbo].[tb_Recipe].[ObjActive]
				  ,[dbo].[tb_Recipe].[ExtrnCode]
				  ,[dbo].[tb_Recipe].[ObjTS]
				  ,[dbo].[tb_Recipe].[ObjCrtnTS]
				  ,[dbo].[tb_Recipe].[Posted]
				  ,[dbo].[tb_Recipe].[OrgID]
				  ,[dbo].[tb_Recipe].[SubunitID]
				  ,[dbo].[tb_Recipe].[BegDate]
				  ,[dbo].[tb_Recipe].[EndDate]
				  ,[dbo].[tb_Recipe].[Number]
				  ,[dbo].[tb_Recipe].[ProdID]
				  ,[dbo].[tb_Recipe].[Quantity]
				  ,[dbo].[tb_Recipe].[UnitName]
				  ,[dbo].[tb_Recipe].[UnitID]
				  ,[dbo].[tb_Recipe].[Image]
				  ,[dbo].[tb_Recipe].[OutPut]
				  ,[dbo].[tb_Recipe].[Main]
				  ,[dbo].[tb_Recipe].[CookingTime]
				  ,[dbo].[tb_Recipe].[PrepTechnology]
				  ,[dbo].[tb_Recipe].[ExteriorReqs]
				  ,[dbo].[tb_Recipe].[Comment]
				  ,[dbo].[tb_Product].[Name] as Prodname
				  
				FROM [dbo].[tb_Recipe],[dbo].[tb_Product]
				WHERE [dbo].[tb_Recipe].[ProdID]= '".$ID."'
				AND [dbo].[tb_Recipe].[ProdID]=[dbo].[tb_Product].[ObjID]";
	$getResults= sqlsrv_query($conn, $tsql);

	if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));
	$i=1;
	while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
		$recipe[$i]=$row;
		$i++;
	}

	sqlsrv_free_stmt($getResults);
	//var_dump($recipe);

	//var_dump($bludo);


		foreach ($recipe as $value){
			echo "<div class='recipe'>";
			echo "<div class='recipeProp'>";
				echo "Рецептура № ".$value["Number"]." от ".$value["BegDate"]->format("d-m-Y")."</br>";
				echo "Наименование блюда: <h2>".$value["Prodname"]."</h2>";
				echo "Выход блюда - ".$value["OutPut"]." грамм.</br>";
			echo "</div>";
			echo "<div class='recipeCalc'>";
			$edizm=$recipe[1]["UnitName"];//edizm($value->ЕдиницаИзмерения_Key);
				echo "Рецептура на: </br>";
				echo  "<input class='inputNum' type='number' size='1' onChange='recalc()' name='num' min='1' max='100' value='".$value["Quantity"]."' >".$edizm."</input>";
				echo "</br> Укажите необходимое количество для пересчета </br>";
			echo "</div>";
			echo "<div style='clear:both;'></div>";
			echo "Технология приготовления:".$value["PrepTechnology"]."</br>";
			echo "<table>";
				echo "<tr>";
					echo "<th>№</th>";
					echo "<th>Продукт</th>";
					echo "<th>Брутто</th>";
					echo "<th>Нетто</th>";
					echo "<th>Выход</th>";
					echo "<th>Рецептура</th>";
				echo "</tr>";
			$tsql= "SELECT [dbo].[tb_RecItem].[LinkID]
				  ,[dbo].[tb_RecItem].[Pos]
				  ,[dbo].[tb_RecItem].[ProdName]
				  ,[dbo].[tb_RecItem].[ProdID]
				  ,[dbo].[tb_RecItem].[QntAll]
				  ,[dbo].[tb_RecItem].[QntNet]
				  ,[dbo].[tb_RecItem].[QntOut]
				  ,[dbo].[tb_RecItem].[UnitName]
				  ,[dbo].[tb_RecItem].[UnitID]
				  ,[dbo].[tb_RecItem].[RecipeID]
				  ,[dbo].[tb_RecItem].[Spice]
				  ,[dbo].[tb_Product].[Name] as Prodname
				  
				FROM [dbo].[tb_RecItem],[dbo].[tb_Product]
				WHERE [dbo].[tb_RecItem].[LinkID]= '".$value["ObjID"]."'
				AND [dbo].[tb_RecItem].[ProdID]=[dbo].[tb_Product].[ObjID]";
			$getResults1= sqlsrv_query($conn, $tsql);

			if ($getResults1 == FALSE) die(FormatErrors(sqlsrv_errors()));
			$i=1;
			
			while ($row = sqlsrv_fetch_array($getResults1, SQLSRV_FETCH_ASSOC)) {
				$goods[$i]=$row;
				$i++;
			}
			sqlsrv_free_stmt($getResults1);
			$i=1;	
			foreach ($goods as $good){
				
				echo "<tr>";
					echo "<td id='tb_num'>".$i."</td>";
					echo "<td id='tb_name'>".$good["Prodname"]."</td>";
					echo "<td id='tb_brutto'>".number_format($good["QntAll"],3)."</td>";
					echo "<td id='tb_netto'>".number_format($good["QntNet"],3)."</td>";
					echo "<td id='tb_out'>".number_format($good["QntOut"],3)."</td>";
					if ($good["RecipeID"]<>'00000000-0000-0000-0000-000000000000'){
						$returnID["included"][]=$good["RecipeID"];
						echo "<td id='tb_recipe'>Есть</td>";
					} else {
						echo "<td id='tb_recipe'></td>";
					}
				echo "</tr>";
				$i++;
			}
			
			echo "</table>";
			echo "</div>";
			$returnID["viewed"][] = $value["ObjID"];
			
		}
	return $returnID;
}	

function viewRecipeByID($ID){
		global $conn;
	$tsql= "SELECT [dbo].[tb_Recipe].[ObjID]
				  ,[dbo].[tb_Recipe].[ObjActive]
				  ,[dbo].[tb_Recipe].[ExtrnCode]
				  ,[dbo].[tb_Recipe].[ObjTS]
				  ,[dbo].[tb_Recipe].[ObjCrtnTS]
				  ,[dbo].[tb_Recipe].[Posted]
				  ,[dbo].[tb_Recipe].[OrgID]
				  ,[dbo].[tb_Recipe].[SubunitID]
				  ,[dbo].[tb_Recipe].[BegDate]
				  ,[dbo].[tb_Recipe].[EndDate]
				  ,[dbo].[tb_Recipe].[Number]
				  ,[dbo].[tb_Recipe].[ProdID]
				  ,[dbo].[tb_Recipe].[Quantity]
				  ,[dbo].[tb_Recipe].[UnitName]
				  ,[dbo].[tb_Recipe].[UnitID]
				  ,[dbo].[tb_Recipe].[Image]
				  ,[dbo].[tb_Recipe].[OutPut]
				  ,[dbo].[tb_Recipe].[Main]
				  ,[dbo].[tb_Recipe].[CookingTime]
				  ,[dbo].[tb_Recipe].[PrepTechnology]
				  ,[dbo].[tb_Recipe].[ExteriorReqs]
				  ,[dbo].[tb_Recipe].[Comment]
				  ,[dbo].[tb_Product].[Name] as Prodname
				  
				FROM [dbo].[tb_Recipe],[dbo].[tb_Product]
				WHERE [dbo].[tb_Recipe].[ObjID]= '".$ID."'
				AND [dbo].[tb_Recipe].[ProdID]=[dbo].[tb_Product].[ObjID]";
	$getResults= sqlsrv_query($conn, $tsql);

	if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));
	$i=1;
	while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
		$recipe[$i]=$row;
		$i++;
	}

	sqlsrv_free_stmt($getResults);
		echo "<div class='recipe'>";
			echo "<div class='recipeProp'>";
				echo "Рецептура № ".$recipe[1]["Number"]." от ".$recipe[1]["BegDate"]->format("d-m-Y")."</br>";
				echo "Наименование блюда: <h2>".$recipe[1]["Prodname"]."</h2>";
				echo "Выход блюда - ".$recipe[1]["OutPut"]." грамм.</br>";
			echo "</div>";
			echo "<div class='recipeCalc'>";
				$edizm=$recipe[1]["UnitName"];//edizm($value->ЕдиницаИзмерения_Key);
				echo "Рецептура на: </br>";
				echo  "<input class='inputNum' type='number' size='1' onChange='recalc()' name='num' min='1' max='100' value='".$recipe[1]["Quantity"]."' >".$edizm."</input>";
				echo "</br> Укажите необходимое количество для пересчета </br>";
			echo "</div>";
			echo "<div style='clear:both;'></div>";
			echo "Технология приготовления:".$recipe[1]["PrepTechnology"]."</br>";
			echo "<table>";
				echo "<tr>";
					echo "<th>№</th>";
					echo "<th>Продукт</th>";
					echo "<th>Брутто</th>";
					echo "<th>Нетто</th>";
					echo "<th>Выход</th>";
					echo "<th>Рецептура</th>";
				echo "</tr>";
			$tsql= "SELECT [dbo].[tb_RecItem].[LinkID]
				  ,[dbo].[tb_RecItem].[Pos]
				  ,[dbo].[tb_RecItem].[ProdName]
				  ,[dbo].[tb_RecItem].[ProdID]
				  ,[dbo].[tb_RecItem].[QntAll]
				  ,[dbo].[tb_RecItem].[QntNet]
				  ,[dbo].[tb_RecItem].[QntOut]
				  ,[dbo].[tb_RecItem].[UnitName]
				  ,[dbo].[tb_RecItem].[UnitID]
				  ,[dbo].[tb_RecItem].[RecipeID]
				  ,[dbo].[tb_RecItem].[Spice]
				  ,[dbo].[tb_Product].[Name] as Prodname
				  
				FROM [dbo].[tb_RecItem],[dbo].[tb_Product]
				WHERE [dbo].[tb_RecItem].[LinkID]= '".$recipe[1]["ObjID"]."'
				AND [dbo].[tb_RecItem].[ProdID]=[dbo].[tb_Product].[ObjID]";
			$getResults1= sqlsrv_query($conn, $tsql);

			if ($getResults1 == FALSE) die(FormatErrors(sqlsrv_errors()));
			$i=1;
			
			while ($row = sqlsrv_fetch_array($getResults1, SQLSRV_FETCH_ASSOC)) {
				$goods[$i]=$row;
				$i++;
			}
			sqlsrv_free_stmt($getResults1);
			$i=1;	
			foreach ($goods as $good){
				
				echo "<tr>";
					echo "<td id='tb_num'>".$i."</td>";
					echo "<td id='tb_name'>".$good["Prodname"]."</td>";
					echo "<td id='tb_brutto'>".number_format($good["QntAll"],3)."</td>";
					echo "<td id='tb_netto'>".number_format($good["QntNet"],3)."</td>";
					echo "<td id='tb_out'>".number_format($good["QntOut"],3)."</td>";
					if ($good["RecipeID"]<>'00000000-0000-0000-0000-000000000000'){
						$returnID["included"][]=$good["RecipeID"];
						echo "<td id='tb_recipe'>Есть</td>";
					} else {
						echo "<td id='tb_recipe'></td>";
					}
				echo "</tr>";
				$i++;
			}
			
			echo "</table>";
			echo "</div>";
			$returnID["viewed"][] = $recipe[1]["ObjID"];
		
	
	
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
                width: 70px;
                height: 70px;
                border: solid grey 1px;
                position: fixed;
                border-radius: 10px;
                right: 10px;
                cursor: pointer;
				z-index: 100;
				background-color: white;
				background-size: contain;
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

	$viewed=array_merge($viewed,$a["viewed"]);

	foreach ($a["included"] as $guid) {
		$test_viewed=true;
	foreach ($viewed as $viewed_guid){
			if ($guid==$viewed_guid) $test_viewed=false;
		}
	
		if($test_viewed==true){
			$n=viewRecipeByID($guid);
		}	

	}
	
?>
</body>
</html>