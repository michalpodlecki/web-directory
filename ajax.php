<?php
//header('Content-Type: text/html');
define('CLASS_DIR', 'classes');
session_start();

function __autoload($className) {
	include_once(CLASS_DIR . '/' . $className . '.php');
}

$model = new AppModel();
$ifuser = $_GET['username'];

$result = $model->pdo->query('select * from users where username=\''.$ifuser.'\'');
if (!empty($result->fetch())) {
	echo 'error';
}
?>
