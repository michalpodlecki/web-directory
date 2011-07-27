<?php
class View {
    private $layout;
	public function __construct() {
		$this->layout = '_layout';
	}

	public function getContent() {
		include VIEWS.'/'.$this->layout.'.php';
	}
}
?>
