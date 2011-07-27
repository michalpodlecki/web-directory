<?php
define('CSS', '../css');
include 'HtmlHelper.php';
$html = new HtmlHelper();
//var_dump($html);
class Config {
    public static function load($filename) {
	 require('../config/'.$filename.'.php');
	}
	public static function getLayout() {
		return include '../views/layout.php' ;
	}
}
include '../views/layout.php' ;
//Config::getLayout();
?>
