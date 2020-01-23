<?php
if (isset($_GET['date1']) ) {
    $date1 = new DateTime($_GET['date1']);
} else {
    $date=new DateTime();
}
if (isset($_GET['date2']) ) {
    $date2 = new DateTime($_GET['date2']);
} else {
    $date=new DateTime();
}

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
function type_of_payment($connect){

$query= "SELECT [ObjID],
				[Name],
				[IsFisc]
        FROM [CAFE].[dbo].[tb_PayType]
		ORDER BY [dbo].[tb_PayType].[IsFisc] DESC";
		
$getResults= sqlsrv_query($connect, $query);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[]=$row;
    $i++;
}
sqlsrv_free_stmt($getResults);
return $data;
}

function count_sum_period($connect,$date1,$date2,$type){

$query= "SELECT SUM([dbo].[tb_ShfPay].[SumSale])
        FROM [CAFE].[dbo].[tb_Shift] INNER JOIN [CAFE].[dbo].[tb_ShfPay]
		ON [CAFE].[dbo].[tb_Shift].[ObjID]= [CAFE].[dbo].[tb_ShfPay].[LinkID]
        WHERE [dbo].[tb_Shift].[DateBeg] BETWEEN '". $date1."' and '".$date2."'
        AND [CAFE].[dbo].[tb_ShfPay].[PayTypeID]='".$type."'";

    $getResults= sqlsrv_query($connect, $query);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data=$row[''];
    $i++;
}

sqlsrv_free_stmt($getResults);
return $data;
	
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


?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Показатель выручки</title>
	<style type="text/css">
		body {
			width: 100%;
			height: 100%;
		}
		.hour {
			width: 100px;
			height: 250px;
			float: left;
			position: relative;
			
		}
		.hours_name {
			width: 80px;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 12pt;
			color: skyblue;
			text-align: center;
			padding: 10px;
		}
		.quantity_graf {
			margin: auto;
			width: 50px;
			background-color: red;
			position: absolute;
			bottom: 0;
			left: 25px;
		}
		.orders_quantity {
			color: red;
			font-size: 16pt;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			text-align: center;
		}
		#label {
			color: gray;
			text-align: center;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 40px;
			height: 100px;
		}
		#orders_quantity_sum {
			color: red;
			text-align: center;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 40px;
		}
		#graf_area {
			width: 100%;
			height: 250px;
			background-color:whitesmoke;
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
		}
		#quantity_graf_1 {
			height: <?=$orders_quantity_1?>px;
		}
		#quantity_graf_2 {
			height: <?=$orders_quantity_2?>px;
		}
		#quantity_graf_3 {
			height: <?=$orders_quantity_3?>px;
		}
		#quantity_graf_4 {
			height: <?=$orders_quantity_4?>px;
		}
		#quantity_graf_5 {
			height: <?=$orders_quantity_5?>px;
		}
		#quantity_graf_6 {
			height: <?=$orders_quantity_6?>px;
		}
		#quantity_graf_7 {
			height: <?=$orders_quantity_7?>px;
		}
	</style>	
</head>
<body>
<?php
$paytype=type_of_payment($conn);
$total_sum_fisc=0;
$total_sum_nofisc=0;
//var_dump($paytype);
$area=NULL;
foreach ($paytype as $value){
	$sales_sum=count_sum_period($conn,$date1->format("Ymd 00:00:00"),$date2->format("Ymd 23:59:59"),$value[ObjID]);
	if ($value[IsFisc]<>1) $total_sum_nofisc=$total_sum_nofisc+$sales_sum;
	if ($value[IsFisc]=1) $total_sum_fisc=$total_sum_fisc+$sales_sum;
	if ($sales_sum<>0)echo $value[Name]." ".number_format($sales_sum, 2, ',', ' ')."<br/>";
	
}
echo "Итого фискальных: ".number_format($total_sum_fisc, 2, ',', ' ')."<br/>";
echo "Итого нефискальных: ".number_format($total_sum_nofisc, 2, ',', ' ');	
?>  
</body>
</html>