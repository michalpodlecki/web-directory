<?php
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	print_r($_POST);
	extract($_POST); // zamienia tablicę POST na zestaw zmiennych
	if(empty($password)) {
		$password = $user['PASSWORD'];
	}
	$result = $model->pdo->exec("UPDATE users SET username='$username', password='$password', email='$email' WHERE id=".$user['ID']);
	//header('Location: index.php');
	$_SESSION['user']['EMAIL'] = $email; // aktualizacja sesji o adres email
}
$data = $model->pdo->query("SELECT username, email FROM users WHERE id=".$user['ID']);
	$x = $data->fetch(PDO::FETCH_ASSOC);
if (isset($_SESSION['user'])) {
	//$result = $model->pdo->query('SELECT * FROM users WHERE id='.$user['ID']);
	//$user = $_SESSION['user'];
	//print_r($_SESSION);
?>

<h1>Edycja profilu</h1>
<form id="login-form" action="?a=edit" method="post">
    <label for="username">Nazwa użytkownika:</label><input id="username" name="username" type="text" value="<?php echo $x['USERNAME']; ?>" readonly="readonly" style="background: lightGoldenrodYellow" />
    <label for="password">Hasło:</label><input id="password" name="password" type="password" autocomplete="off" />
    <label for="repassword">Powtórz hasło:</label><input id="repassword" name="repassword" type="password" />
    <label for="email">Adres email:</label><input id="email" name="email" type="text" value="<?php echo $x['EMAIL']; ?>" />
    <input type="submit" value="Zatwierdź zmiany" />
</form>
<div>
    <a href="index.php">Powrót</a>
</div>
 <?php } ?>