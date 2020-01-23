<?php
 
session_start();

//require_once ("lib/security.php");
//$security= new security();
//$security->testUser();
?>


<!doctype html>
<html>
	
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Выпуск блюд</title>    
    <link href="css/cook_dashboard.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <script src="js/cook_dashboard.js" defer ></script>
</head>
<body>
<?php
require_once('status_bar.php');?>
	<div id="dashboard">
	</div>
</body>
</html>