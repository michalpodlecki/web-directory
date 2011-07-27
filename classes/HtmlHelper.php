<?php
class HtmlHelper {
    //put your code here
    public function __construct() {
    }

    public function css($name) {
        return '<link rel="stylesheet" href="'.CSS.'/'.$name.'.css" />';
    }
}
?>