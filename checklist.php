<?php
$structure='{
                "menu":{
                        "menuitems": [
                            {"name":"Регламенты","id":"reglament","parent":""},
                            {"name":"Инспектор","id":"inspector","parent":""},
                            {"name":"Задачи","id":"tasks","parent":""},
                            {"name":" Отчет","id":"report","parent":""},
                            {"name":"Вход","id":"auth","parent":""},
                            ],
                        "parent":""
                        }
                "reglament":[
                            {"reglname":"Открытие кафе", "id":"reglist1","parent":"reglament"}
                ]
                        
            }';
?>
<!DOCTYPE html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>CheckList</title>
   <style>
   html, body {
		width:100%;
		height:100%;
		margin:0;
		padding:0;
       font-family: sans-serif;
   }
   nav {
		display:flex;
       justify-content: space-around;
		align-items:center;
	}
	a {
		text-decoration: none; /*убираем подчеркивание текста ссылок*/
		display:block;
	}
	#menu {
		height: 100%;
        font-size: 2rem;
        
	}
    #menu a {
		color:white;
        margin: 2%;
	}
	
   #header {
		width:100%;
		height:5%;
		position:fixed;
		top:0;
		background-color:grey;
		color:white;
       z-index: 10;
	   
   }
       .dashboard {
           position: absolute;
           top: 0;
           width: 100%;
           height: 100%;
           background-color: beige;
           display: flex;
           flex-wrap: wrap;
           justify-content: flex-start;
           align-content: center;
       }
       .dbitem {
           width: 25%;
           height: 25%;
           margin: 1%;
           padding: 1rem;
           color: white;
           background-color: cadetblue;
           display: flex;
           justify-content: center;
           align-items: center;
           text-align: center;
           font-size: 2rem;
           
       }
       .checklist {
           position: absolute;
           top: 0;
           width: 100%;
           height: 100%;
           background-color: beige;
           display: flex;
           flex-wrap: wrap;
           justify-content: flex-start;
           align-content: center;
       }
       .check {
           width: 90%;
           height: 10%;
           margin: 1%;
           padding: 1rem;
           color: white;
           background-color: cadetblue;
           display: flex;
           justify-content: center;
           align-items: center;
           text-align: center;
           font-size: 2rem;
       }
       #reglament {
          z-index: 3;
       }
        #reglament .dbitem  {
            background-color: cadetblue;
       }
       
       #inspector {
           z-index: 2;
        }
       #inspector .dbitem  {
           background-color: blueviolet;
       }
       #tasks {
           z-index: 1;
        }
        #tasks .dbitem { 
           background-color: firebrick;
       }
   #footer {
		width:100%;
		height:5%;
		position:fixed;
		bottom:0;
		background-color:grey;
		color:white;
       z-index: 10;
   }
       #main {z-index: 0;}
       #main div:target {z-index: 3;}
       /*#checklsts {z-index: 0;}
       #checklsts div:{z-index: 3;}*/
   </style>
</head>
<body>
<div id="header">
	<nav id="menu">
		<a href="#reglament">Регламенты</a>
		<a href="#inspector">Инспектор</a>
		<a href="#tasks">Задания</a>
		<div>Отчет</div>
        <div>Войти</div>
	</nav>
</div>
<div id="main">    
    <div class="dashboard" id="reglament">
        
            <a class="dbitem" href="#reg1">Открытие кафе</a>
            <a class="dbitem" href="#reg2">Проверка оборудования</a>
            <a class="dbitem" href="#reg3">Подготовка к банкету</a>
            <a class="dbitem" href="#reg4">Закрытие кафе</a>
            <a class="dbitem" href="#reg5">Подготовка к банкету</a>
            <a class="dbitem" href="#reg6">Подготовка к банкету</a>
    </div>  
    <div id="checklsts">
        <div class="checklist" id="reg1">
            <div class="check">Свет включен</div>
            <div class="check">Светильники работают</div>
            <div class="check">Батареи горячие</div>
            <div class="check">Кран не течет</div>
            <div class="check">Жопа не болит</div>
        </div>
        <div class="checklist" id="reg2">
            <div class="check">Холодильник</div>
            <div class="check">Печь</div>
            <div class="check">Пароконвектомат</div>
            <div class="check">Слайсер</div>
            <div class="check">Жопа не болит</div>
        </div>

    </div>
    
    <div class="dashboard" id="inspector">
        <a class="dbitem" href="#place1">Раздача</a>
        <a class="dbitem" href="#place2">Вестибюль</a>
        <a class="dbitem" href="#place3">Зал</a>
        <a class="dbitem" href="#place4">Бар</a>
        <a class="dbitem" href="#place5">Кухня</a>
    </div>
    <div id="placelsts">
        <div class="dashboard" id="place1">
            <a class="dbitem" href="#item1">Свет включен</a>
            <a class="dbitem" href="#item2">Светильники работают</a>
            <a class="dbitem" href="#item3">Батареи горячие</a>
            <a class="dbitem" href="#item4">Кран не течет</a>
            <a class="dbitem" href="#inspector">Назад</a>
        </div>
        <div class="dashboard" id="place2">
            <a class="dbitem" href="#item5">Холодильник</a>
            <a class="dbitem" href="#item6">Печь</a>
            <a class="dbitem" href="#item7">Пароконвектомат</a>
            <a class="dbitem" href="#item8">Слайсер</a>
            <a class="dbitem" href="#inspector">Назад</a>
        </div>

    </div>
    <div class="dashboard" id="tasks">
        <div class="dbitem"> Убрать говно</div>
        <div class="dbitem">Ввернуть лампочку</div>
        <div class="dbitem">Помыть пол</div>
        <div class="dbitem">Закрытие кафе</div>

    </div>
</div>
<div id="footer"></div>
    
</body>
</html>