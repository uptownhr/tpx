<?php

class AuthController extends My_Controller {

    public function init(){
        parent::init();
    }


    public function registerAction(){
		$data = Jien::sanitizeArray($_POST);

		if(empty($data['username'])){
			$error['msg'] = "Username can't be blank";
			$error['focus'] = "username";
		}else if(empty($data['password'])){
			$error['msg'] = "Password can't be blank";
			$error['focus'] = "password";
		}else if(empty($data['password2'])){
			$error['msg'] = "Confirmation password can't be blank";
			$error['focus'] = "password2";
		}else if($data['password'] != $data['password2']){
			$error['msg'] = "Passwords do not match";
			$error['focus'] = "password";
		}
		if(!empty($error)){
			$this->json($error, 401, 'input validation error');
		}

		try {
			$data['role_id'] = 2;
			$user_id = Jien::model("User")->save($data);

			$auth = $this->authenticate($data['username'], $data['password']);
			$res = array();
			if($auth){
				Jien::model("User")->save(array(
					"user_id"	=>	$_SESSION['user']->user_id,
					"accessed"	=>	new Zend_Db_Expr('NOW()'),
				));
				$this->json(array("user"=>$_SESSION['user']), 200, 'logged in');
			}else{
				$this->json(array(), 401, 'invalid credentials');
			}

		}catch(Exception $e){
			$this->json(array(), 401, $e->getMessage());
		}
    }

	public function loginAction(){
		$data = Jien::sanitizeArray($_POST);
		if(empty($data['username'])){
			$error['msg'] = "Username can't be blank";
			$error['focus'] = "username";
		}else if(empty($data['password'])){
			$error['msg'] = "Password can't be blank";
			$error['focus'] = "password";
		}
		if(!empty($error)){
			$this->json($error, 401, 'input validation error');
		}

		$auth = $this->authenticate($data['username'], $data['password']);
		$res = array();
		if($auth){

			// updates accessed field to now
			Jien::model("User")->save(array(
				"user_id"	=>	$_SESSION['user']->user_id,
				"accessed"	=>	new Zend_Db_Expr('NOW()'),
			));

			$this->json(array("user"=>$_SESSION['user']), 200, 'logged in');

		}else{
			$error['msg'] = 'Invalid user/pass, try again';
			$error['focus'] = 'username';
			$this->json($error, 401, 'invalid credentials');

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
