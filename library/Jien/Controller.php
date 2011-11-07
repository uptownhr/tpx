<?php

class Jien_Controller extends Zend_Controller_Action {

    public function init(){

    	// pass request params to view
    	$this->view->params = $this->params();
		$this->view->auth = $this->auth = Zend_Auth::getInstance();

		// setup auth / acl
		$role = 'guest';

		// if user logged in
		if(!empty($_SESSION['user'])){
			$this->view->user = $_SESSION['user'];
		}

		// activate access control
		$this->accessControl();

    }

    public function accessControl(){
    	$acl = new Zend_Acl();
    	$acl->addRole(new Zend_Acl_Role('guest'));
    	$acl->addRole(new Zend_Acl_Role('member'), 'guest');
    	$acl->addRole(new Zend_Acl_Role('vip member'), 'member');
    	$acl->addRole(new Zend_Acl_Role('moderator'), 'vip member');
    	$acl->addRole(new Zend_Acl_Role('admin'), 'moderator');


    	//$acl->allow('moderator', 'admin');

    }

    public function setUser($user){
    	$user = (array) $user;

    	if($user['uid'] != 0){
			$condi = "provider_id = {$user['provider_id']} AND uid = '{$user['uid']}'";
    	}else{
    		$condi = "user_id = '{$user['user_id']}'";
    	}
        $data = Jien::model("User")->where($condi)->joinRole()->get()->row();
        if(!$data){
        	$user['user_id'] = Jien::model("User")->save($user);
        }else{
        	$user['accessed'] = new Zend_Db_Expr('NOW()');
        	$user['user_id'] = Jien::model("User")->update($user, $condi);
        }
        $user['accessed'] = date("Y-m-d h:i:s");
        $user['role'] = $data['role'];
		$_SESSION['user'] = $user;
    }

    /*
    * below are my main controller methods, some are just renaming the ugly zend framework naming schema
    */

    protected function params($param = '', $default = ''){

		$request = Zend_Controller_Front::getInstance()->getRequest();
		if($param){
			return $request->getParam($param, $default);
		}else{
			return $request->getParams();
		}

    }

    // renders a script i.e; admin/form will render admin/form.phtml
    public function view($script){
        $this->_helper->viewRenderer($script);
    }

    // will retrieve the contents of the file (filename with extensions, i.e; admin/form.phtml)
    public function load($file){
        return $this->render($file);
    }

    public function layout($script){
    	$this->_helper->layout()->setLayout($script);
    }

    public function flash($msg){
    	$this->_helper->FlashMessenger($msg);
    }

    public function redir($url){
    	$this->_redirect($url);
    }

    public function json($data, $code = '', $msg = ''){
    	if($code != ''){
    		$data = Jien::outputResult($code, $data, $msg);
    	}
    	$this->_helper->json($data);
    }

    public function me(){
    	$identity = $this->auth->getIdentity();
    	$res = array();
    	$res = $identity['properties'];
    	return $res;
    }

}
