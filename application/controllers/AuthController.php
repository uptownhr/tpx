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

			$this->json(array("user"=>$_SESSION['user']), 200, 'logged in');

		}else{

			$this->json(array(), 401, 'invalid credentials');

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

			$this->json(array("user"=>$_SESSION['user']), 200, 'logged in');

		}else{

			$this->json(array(), 401, 'invalid credentials');

		}

	}

	public function logoutAction(){
		unset($_SESSION['user']);
		$this->auth->clearIdentity();
        $this->flash('You were logged out');
        $this->json(array(), 200, 'logged out');
	}

}
