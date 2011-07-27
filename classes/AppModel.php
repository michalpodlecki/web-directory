<?php
class AppModel {
    public $pdo;
	private $result;
	private $user_id;
    public function __construct() {
       // if($driver == null) {
            $this->pdo = new PDO('java:comp/env/testDB');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if(is_object($this->pdo)) { /*echo 'baza działa!';*/ }
			//print_r($driver);
        else {
            echo 'brak połączenia z bazą!';
        }
    }
	public function getAllFiles($user_id = null) {
		if (empty($user_id)) {
			throw new Exception('method: getAllFiles($user_id); $user_id jest null');
		}
        $this->user_id = $user_id['ID'];
		$this->result = $this->pdo->query("SELECT * FROM files WHERE user_id=".$this->user_id." AND c_id=0 ORDER BY file_type ASC");
		return $this->result;
	}
    public function getFilesOfCatalog($user_id = null, $c_id) {
		if (empty($user_id)) {
			throw new Exception('method: getAllFiles($user_id); $user_id jest null');
		}
        $this->user_id = $user_id['ID'];
		$this->result = $this->pdo->query("SELECT * FROM files WHERE user_id=".$this->user_id." AND c_id=".$c_id." ORDER BY file_type ASC");
		return $this->result;
	}
	public function getFilesByName($name) {
		$this->result = $this->pdo->query("SELECT * FROM files WHERE user_id=".$_SESSION['user']['ID']." AND file_name LIKE '%".$name."%'");
		return $this->result;
	}
    
    function changeFileName($id, $filename) {
        $this->result = $this->pdo->exec("UPDATE files SET file_name='$filename', modified='".date('Y-m-d H:i:s')."' WHERE id=$id");
        return $this->result;
    }
    
    function deleteFile($id) {
        $this->result = $this->pdo->exec("DELETE FROM FILES WHERE id=$id");
        return $this->result;
    }
    
    function moveFile($id, $cid) {
        $this->result = $this->pdo->exec("UPDATE files SET c_id=$cid, modified='".date('Y-m-d H:i:s')."' WHERE id=$id");
        return $this->result;
    }
    
    public function getCatalogsByName($name) {
		$this->result = $this->pdo->query("SELECT * FROM files WHERE user_id=".$_SESSION['user']['ID']." AND file_name LIKE '%".$name."%' AND file_type='catalog'");
		return $this->result;
	}
}

?>