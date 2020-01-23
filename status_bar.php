<div class="status-bar">
	<div id="status-bar-user">Пользователь: <?=$_SESSION["username"]?></div>
	<form action="exit_session.php" method="POST">
		<button class="button-100x40" id='session_exit' type='submit'>Выйти</button>
	</form>			
</div>