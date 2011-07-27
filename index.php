<?php
define('CLASS_DIR', 'classes');
define('CSS', 'css');
define('JS', 'js');
define('VIEWS', 'views');
define('UPLOAD', 'upload');
session_start();

function __autoload($className) {
	include_once(CLASS_DIR . '/' . $className . '.php');
}

$fc = new FrontController($request);
$fc->dispatch();

?>