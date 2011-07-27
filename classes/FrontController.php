<?php
include 'AppModel.php';
include 'HtmlHelper.php';

class FrontController {
	private $action;
	private $controller;
	private $model;
	private $html;
	private $post;
	private $content;
	private $data;
	private $request;
    private $user = null;
	
    public function  __construct() {       
		$this->request = &$_GET;
        $this->action = isset($this->request['a'])? $this->request['a'] : 'index';
        $this->controller = isset($this->request['c'])? $this->request['c'] : 'brak podanego kontrolera w url';
		$this->model = new AppModel();
		$this->html = new HtmlHelper();
	}
    
	public function dispatch() {
		if(method_exists($this, $this->action)) {
			//$action = $this->action;
			//eval('$this->'."$this->action".'()');
			//$this->$action();
            sleep(1);
			call_user_func(array(&$this, $this->action));
		}
		else {
			exit('<br />metoda '.strtoupper($this->action).' nie zostala zaimplementowana');
		}
	}
	
	/*
	 * Ustawia odpowiedni widok dla akcji
	 * @param string $view Name of the view to load
	 * @param mixed $params There are optionally used in the view
	 * @param boolean $layout If $layout is set to false, there
	 * won't be layout around the view, used in ajax request
	 */
	public function setView($view, $params = null, $layout = true) {
		//$this->content = include VIEWS.'/'.$view.'.php';
		//include VIEWS.'/'.$view.'.php';
		//return $this->content;
        if(!defined('VIEWS')) {
			exit("Stała VIEWS nie odnaleziona");
		}
		$html = $this->html;
		$model = $this->model;
		$data = $params;
		ob_start(); // output buffer on
		include VIEWS.'/'.$view.'.php';
		$this->content = ob_get_contents();
		ob_end_clean(); // output buffer clean & off
		$content_for_layout = &$this->content;

        //sleep(1);
        
		if(!$layout) {
			echo $this->content;
			exit;
		}
		include VIEWS.'/_layout.php';
	}

    public function index() {
        if (isset($_SESSION['user'])) {
            $this->showfiles();
        }
        else {
            $this->setView('login');
        }  
    }

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user = $this->model->pdo->query("SELECT * FROM users WHERE username='".$_POST['username']."' AND password='".$_POST['password']."'");
			$result = $user->fetch(PDO::FETCH_ASSOC);
			$_SESSION['user'] = $result;
            if (!empty($_SESSION['user'])) {
                $this->showfiles(); // po zalogowaniu przenosi do widoku showfiles
            } else {
                header('Location: index.php');
                session_destroy();
                session_start();
                $_SESSION['info'] = 'Błędny login lub hasło';
            }
		}
        else {
            echo $_SESSION['info'];
            unset($_SESSION['info']);
            $this->setView('login');
        }
	}

	public function logout() {
		session_destroy();
		header('Location: index.php');
	}

	public function edit() {
		$model = $this->model;
		$this->setView('edit', null, false);
	}

	public function files() {
		$model = &$this->model;
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			$this->setView('upload-form', null, false);
		}
		else {
//			print_r($_FILES);
			//$file = basename($_FILES['file']['name']);
            $filename_parts = pathinfo($_FILES['file']['name']);
//            print_r($filename_parts);
//            $file_extension = $filename_parts['extension'];
            $filename = basename($_FILES['file']['name']); // , '.'.$file_extension
            $file_extension = array_pop(explode('.', $filename));
            //$filename = utf8_encode($filename);
			$fn_from = array('ą','Ą','ć','Ć','ę','Ę','ł','Ł','ń','Ń','ó','Ó','ś','Ś','ź','Ź','ż','Ż',' ');
			$fn_to = array('a','A','c','C','e','E','l','L','n','N','o','O','s','S','z','Z','z','Z','_');
			$filename = str_replace($fn_from, $fn_to, $filename);
            $filename = basename($filename, '.'.$file_extension); // wyrzucenie rozszerzenia z nazwy pliku
            $file_path = uniqid('', true).'.'.$file_extension; // unikalna nazwa pliku
			$destination = UPLOAD.'/'.$file_path;
            $c_id = 0; // domyslnie, 0 - root
			if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
					//echo '<br />Plik wgrany';
					$model->pdo->exec('INSERT INTO files(file_name, file_type, file_size, user_id, file_path, file_extension, c_id, modified) VALUES(\''.$filename.'\', \''.$_FILES['file']['type'].'\', '.$_FILES['file']['size'].', '.$_SESSION['user']['ID'].', \''.$file_path.'\', \''.$file_extension.'\', '.$c_id.', \''.date('Y-m-d H:i:s').'\')') or die(print_r($model->pdo->errorInfo(), true));
//                    $this->showfiles();
                    header('Location: index.php');
                }
//				$this->showfiles();
			}
			else {
                exit($_FILES['file']['error']);
			}
		}
	}

	public function showfiles() {
		$model = &$this->model;
        $result = $model->getAllFiles($_SESSION['user']);
        $files = $result->fetchAll(PDO::FETCH_ASSOC);
        $files['cid'] = 0;
        $files['pid'] = 0;
        $files['cname'] = 0;
        $this->setView('showfiles', $files);
	}

	public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['password'] == $_POST['repassword']) {
                $model->pdo->exec('INSERT INTO USERS(USERNAME, PASSWORD, EMAIL) VALUES(\'' . $_POST['username'] . '\',\'' . $_POST['password'] . '\',\'' . $_POST['email'] . '\')') or die(print_r($model->pdo->errorInfo(), true));
                session_destroy();
                header('Location: index.php');
            } else {
                header('Location: index.php?a=register');
                $_SESSION['info'] = 'Hasła nie zgadzają się!';
            }
        } else {
            echo $_SESSION['info'];
            unset($_SESSION['info']);
            $this->setView('register');
        }
    }

    /*
     * Zwraca liste plikow i katalogow
     */
	public function ajax() {
		$model = &$this->model;
        if (isset($_GET['cid'])) {
            $result = $model->getFilesOfCatalog($_SESSION['user'], $_GET['cid']);
        } else {
            $result = $model->getFilesByName($_GET['q']);
        }
        $parent = $model->pdo->query('SELECT c_id, file_name FROM files WHERE id='.$_GET['cid']);
        $parent_result = $parent->fetch(PDO::FETCH_NUM);
        $catalog_name = $parent_result[1];
        if (is_null($catalog_name)) {
            $catalog_name = 0;
        }
        $parent_result = $parent_result[0];
        if (is_null($parent_result)) {
            $parent_result = 0;
        }
		$files = $result->fetchAll(PDO::FETCH_ASSOC);
        $files['cid'] = $_GET['cid'];
        $files['pid'] = $parent_result; // $_GET['pid'];
        $files['cname'] = $catalog_name;
        //sleep(1);
		$this->setView('filelist', $files, false);
	}
    
    public function filter() {
		$model = &$this->model;
        if (isset($_GET['c_id'])) {
            $result = $model->getFilesOfCatalog($_SESSION['user'], $_GET['c_id']);
        } else {
            $result = $model->getFilesByName($_GET['q']);
        }
		$files = $result->fetchAll(PDO::FETCH_ASSOC);
//        sleep(1);
		$this->setView('searchlist', $files, false);
	}

	public function download() {
		$model = &$this->model;
		$result = $model->pdo->query("SELECT file_name, file_type, file_path, file_extension FROM files WHERE id='".$_GET['fid']."' AND user_id=".$_SESSION['user']['ID']);
		$file = $result->fetch();
		header('Content-Type: '.$file['FILE_TYPE']);
		header('Content-Disposition: inline; filename='.$file['FILE_NAME'].'.'.$file['FILE_EXTENSION']);
		readfile(UPLOAD.'/'.$file['FILE_PATH']);
	}
    
    function delete() {
        $model = &$this->model;
        $result = $model->deleteFile($_GET['fid']);
        if (is_file(UPLOAD . DIRECTORY_SEPARATOR . $_GET['file'])) {
            unlink(UPLOAD . DIRECTORY_SEPARATOR . $_GET['file']);
        }
        $this->showfiles();
    }
    
    function changeFileName() {
        $fid = $_GET['fid'];
        $this->model->changeFileName($fid, $_GET['newname']);
//        $this->ajax();
    }
    
    function addcatalog() {
        $name = $_GET['name'];
        $cid = $_GET['cid'];
        $this->model->pdo->exec('INSERT INTO files(file_name, file_type, user_id, c_id, modified) VALUES(\''.$name.'\', \'catalog\', \''.$_SESSION['user']['ID'].'\', '.$cid.', \''.date('Y-m-d H:i:s').'\')');
    }
    
    function moveFile() {
        $fid = $_GET['fid'];
        $cid = $_GET['cid'];
        $this->model->moveFile($fid, $cid);
    }
       
    public function filterCatalogs() {
		$model = &$this->model;
        $result = $model->getCatalogsByName($_GET['q']);
		$files = $result->fetchAll(PDO::FETCH_ASSOC);
//        sleep(1);
		$this->setView('cataloglist', $files, false);
	}
}
?>