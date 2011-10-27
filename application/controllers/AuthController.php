<?php

class AuthController extends My_Controller {

    public function init(){
        parent::init();
    }

	public function loginAction(){
		$auth = $this->authenticate($_REQUEST['username'], $_REQUEST['password']);
		$res = array();
		if($auth){

			// updates accessed field to now
			Jien::model("User")->save(array(
				"user_id"	=>	$_SESSION['user']->user_id,
				"accessed"	=>	new Zend_Db_Expr('NOW()'),
			));

			echo Jien::outputResultToJson(200, array("user"=>$_SESSION['user']));
			exit;

		}else{

			echo Jien::outputResultToJson(401, array(), "Invalid credentials");
			exit;

		}

	}

	public function loginAdminAction(){
		$auth = $this->authenticate($_REQUEST['username'], $_REQUEST['password'], 10);
		$res = array();
		if($auth){

			// updates accessed field to now
			Jien::model("User")->save(array(
				"user_id"	=>	$_SESSION['user']->user_id,
				"accessed"	=>	new Zend_Db_Expr('NOW()'),
			));

			echo Jien::outputResultToJson(200, array("user"=>$_SESSION['user']));
			exit;

		}else{

			echo Jien::outputResultToJson(401, array(), "Invalid credentials");
			exit;

		}

	}

	public function logoutAction(){
		unset($_SESSION['user']);

		echo Jien::outputResultToJson(200, array());
		exit;

	}

}
