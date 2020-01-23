<?php
  		if ($_GET['screen']==6  ) {
			
			include("reclama.php");
		}
		if ($_GET['screen']==7  ) {
			
			include("/advertisment/bar.php");	
		}
		if ($_GET['screen']==1 or $_GET['screen']==3 or $_GET['screen']==5 ) {
			
					//include("test.php");
  					include("Show_menu.php"); // модуль показа меню	
					//include("/thematic.php");
		} 
		else {
					include("test.php");
  					//include("Show_menu.php");
					//include("/thematic1.php");
		}	

 ?>