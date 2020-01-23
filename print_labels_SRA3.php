<?php
$id=json_decode($_GET["json"]);

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
$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID] AND (";
foreach ($id as $value){
		$tsql=$tsql." [dbo].[tb_MenuItem].[ID]='".$value."' OR ";
            
			}

$tsql = $tsql." [dbo].[tb_MenuItem].[ID]='51A9B17D-8E30-11E3-93EF-00155D012805') ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";


$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $Item[$i]=$row;
    $i++;
}
//var_dump($Item);

sqlsrv_free_stmt($getResults);
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link href="https://fonts.googleapis.com/css?family=Marck+Script|Yanone+Kaffeesatz" rel="stylesheet">
<title>Печать ценников</title>
	<style>
		@font-face {
		font-family: "a_HuxleyRough"; 
    	src: url(fonts/rusfont358.ttf);
	}
		
		body {
            margin: 0;
            padding: 0;
			width: 100%;
			height: 100%;
		}
		#main {
			
            page-break-after: always;
			margin: 0 auto;
            padding-top: 0mm;
			
		}
		.cell_label {
			width: 95mm;
			height: 62mm;
			border: solid 1px grey;
			
		}
        .prod_label {
			position: relative;
            height: 100%;
		}
        .logo {
            width: 100%;
            text-align: center;
            position: absolute;
            top: 3%;
			font-family: 'Yanone Kaffeesatz', sans-serif;
			color:rgba(81,64,188,0.89);
			
        }
		.prod_name {
            width: 100%;
			text-align: center;
            position: absolute;
            top: 15%;
            font-size: 24pt;
            font-weight: bold;
			color: rgba(195,72,3,1.00);
			
		}
        .prod_descript {
            padding: 5%;
            width: 90%;
			text-align: center;
            position: absolute;
			font-family: 'Marck Script', cursive;
            font-size: 16pt;
            top: 40%;
		}
				
        .firm {
            width: 100%;
            text-align: center;
			position: absolute;
            bottom: 0%;
			font-family: 'Yanone Kaffeesatz', sans-serif;
			color:rgba(81,64,188,0.89);
        }
		
	</style>
	
</head>

<body>

	<div id="main">
	<table id="layout" cellspacing="5" align="center">
<?php
    $cell=3;
    foreach ($Item as $value) {
		$comm = json_decode($value["Comment"]);
        if (is_int ($cell/3)) echo '<tr>'.PHP_EOL;
		echo	'<td class="cell_label">'.PHP_EOL;
        echo '      <div class="prod_label">'.PHP_EOL;
        echo '			<div class="logo">кафе "Три Апельсина"</div>'.PHP_EOL;
		echo '			<div class="prod_name">'.$value["Name"].'</div>'.PHP_EOL;
		echo '			<div class="prod_descript">'.$comm->comment.'</div>'.PHP_EOL;
		echo '			<div class="firm">ИП Степановский В.А. ОГРН 312352806100032</div>'.PHP_EOL;
		echo '		</div>'.PHP_EOL;
		echo '	</td>'.PHP_EOL;
        $cell++;
        if (is_int (($cell)/12)) echo '</tr>'.PHP_EOL;
        
    }
?>			
		</table>
	</div>


</body>
</html>