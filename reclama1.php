

<?php /*Данный код формирует страницу для показа всех картинок из папки imgreclama*/
			/* **************************  V Stepanovsky  05.03.2016*****************************/

?>

<!DOCTYPE html>

<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/reclama.css" type="text/css" />
    
   <title>Реклама</title>
</head>

<body bgcolor="#000000">

	 <script defer type="text/javascript" src="js/reclama.js"></script>
        
     <?php
      $dir = 'imgreclama/'; // Папка с изображениями
      $files = scandir($dir); // Берём всё содержимое директории
      echo "<div id='slider' class= 'slider_wrap' >";
			  for ($i = 0; $i < count($files); $i++) { // Перебираем все файлы
				if (($files[$i] != ".") && ($files[$i] != "..")) { // Текущий каталог и родительский пропускаем
				  $path = $dir.$files[$i]; // Получаем путь к картинке
				  echo "<img  src='" .  $path  . "'/>";
				}
			  }
      echo "</div>";
      ?>
	

</body>
</html>

