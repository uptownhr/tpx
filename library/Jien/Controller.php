<?php

class Jien_Controller extends Zend_Controller_Action {

    public function init(){

    	// pass request params to view
    	$this->view->params = Jien::sanitizeArray($this->_request->getParams());
		$this->view->auth = $this->auth = Zend_Auth::getInstance();

		// if user logged in
		if($this->auth->getIdentity()){
			$this->view->user = $_SESSION['user'];
		}

    }

    public function setUser($user){
		$condi = "provider_id = {$user['provider_id']} AND uid = '{$user['uid']}'";
        $data = Jien::model("User")->where($condi)->get()->row();
        if(!$data){
        	$user['user_id'] = Jien::model("User")->save($user);
        }else{
        	$user['accessed'] = new Zend_Db_Expr('NOW()');
        	$user['user_id'] = Jien::model("User")->update($user, $condi);
        }
        $user['accessed'] = date("Y-m-d h:i:s");
		$_SESSION['user'] = $user;
    }

    protected function authenticate($username, $password, $role_id = ''){
        $adapter = $this->_getAuthAdapter($role_id);
        $adapter->setIdentity($username);
        $adapter->setCredential($password);

        $result = $this->auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter($role_id = '') {
        $authAdapter = new Jien_Auth_Adapter_DbTable(Jien::db(), "User", "username", "password", "");
        $select = $authAdapter->getDbSelect();
        if($role_id != ''){
        	$select->where("role_id >= {$role_id} AND active=1");
        }else{
        	$select->where('active=1');
        }
        return $authAdapter;
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
