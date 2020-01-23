<?php>
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
<
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Отчет по карточкам с остатками средств</title>
</head>

<body>
<?
include "soapDDS.php";
?>

	<div>
		<table>
		<?
		foreach () 
			<tr>
				<td></td>
			
			
			</tr>
		</table>
	
	
	
	</div>


</body>
</html>
