<?php

class AuthController extends My_Controller {

    public function init(){
        parent::init();
    }
    
	public function loginAction(){
		$auth = $this->_authenticate($_REQUEST['username'], $_REQUEST['password']);
		$res = array();
		if($auth){
			$res = array(
				"result"	=>	array(
					"code"	=>	200,
					"text"	=>	"success",
				),
				"user"	=>	$_SESSION['user'],
			);
		}else{
			$res = array(
				"result"	=>	array(
					"code"	=>	404,
					"text"	=>	"rejected",
				),
			);
		}
		header('Content-type: application/json');
		echo Zend_Json::encode($res);
		exit;
	}
	
	public function logoutAction(){
		unset($_SESSION['user']);
		$res = array(
			"result"	=>	array(
				"code"	=>	200,
				"text"	=>	"success",
			),
		);
		header('Content-type: application/json');
		echo Zend_Json::encode($res);
		exit;
	}
    
}
