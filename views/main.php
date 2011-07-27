<div id="container">
	<h1>Logowanie</h1>
	<form id="login-form" action="index.php" method="post">
		<label for="username">Nazwa użytkownika:</label><input id="username" name="username" type="text" autocomplete="off" />
		<label for="password">Hasło:</label><input id="password" name="password" type="password"  />
		<input type="submit" value="Zaloguj się" />
	</form>
	<?php if(empty($_SESSION['user'])): ?>
	<div>
		<a href="?controller=register">Zarejestruj się</a>
	</div>
	<?php endif;		//phpinfo(); ?>
</div>