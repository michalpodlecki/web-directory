<?php
define('CLASS_DIR', 'classes');
session_start();

/*function __autoload($className) {
	include_once(CLASS_DIR . '/' . $className . '.php');
}*/
/*$driver = array(
	'dsn' => 'mysql:host=localhost;dbname=web_directory',
	'username' => 'root',
	'password' => ''
);*/
//Config::loads('database');
//print_r($driver);
$model = new AppModel();
$html = new HtmlHelper();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>rejestracja</title>
        <?php echo $html->css('style'); ?>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script type="text/javascript">
			//ajax.init();
			window.onload = function() {
			document.getElementById('username').onkeyup = function() {
				ajax.ajax('GET', 'ajax.php?username='+document.getElementById('username').value, function() {
					if(ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
						//console.log(ajax.XHR);
						if (ajax.XHR.responseText == '\nerror') {
							document.getElementById('username').style.borderColor = 'red';
							document.getElementById('username').style.backgroundColor = 'pink';
							document.getElementById('submit').disabled = 'disabled';
						}
						else {
							document.getElementById('username').style.borderColor = '';
							document.getElementById('username').style.backgroundColor = '';
							document.getElementById('submit').disabled = '';
						}
					}
				});
			}
			}
		</script>
    </head>
    <body>

		<?php
		print_r($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($_POST['password'] == $_POST['repassword']) {
				$model->pdo->exec('INSERT INTO USERS(USERNAME, PASSWORD, EMAIL) VALUES(\''.$_POST['username'].'\',\''.$_POST['password'].'\',\''.$_POST['email'].'\')') or die(print_r($model->pdo->errorInfo(), true));
				echo 'REJESTRACJA UDANA';
				session_destroy();
				header('Location: index.php');
			}
			else {
				header('Location: register.php');
				$_SESSION['info'] = 'hasło musi być podane dwukrotnie takie samo';
			}
		}		
		else {
			echo $_SESSION['info'];
			unset($_SESSION['info']);
		?>


        <div id="container">
			<h1>Rejestracja</h1>
			<form id="login-form" name="formularz" action="?controller=register" method="post">
				<label for="username">Nazwa użytkownika:</label><input id="username" name="username" type="text" autocomplete="off" />
				<label for="password">Hasło:</label><input id="password" name="password" type="password" />
				<label for="repassword">Powtórz hasło:</label><input id="repassword" name="repassword" type="password" />
				<label for="email">Adres email:</label><input id="email" name="email" type="text" />
				<input id="submit" type="submit" value="Rejestruj się" />
			</form>
			<div>
				<a href="/web-directory/">Powrót</a>
			</div>

		</div>
		<?php } ?>
    </body>
</html>
