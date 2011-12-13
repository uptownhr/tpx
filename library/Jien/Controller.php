<?php

class Jien_Controller extends Zend_Controller_Action {

	protected $_resources = array();

    public function init(){

    	// pass request params to view
    	$this->view->params = $this->params();
		$this->view->auth = $this->auth = Zend_Auth::getInstance();

		// if user logged in
		if(!empty($_SESSION['user'])){
			$this->view->user = $this->user = $_SESSION['user'];
		}

		// activate access control
		$this->initAcl();

    }

    public function initAcl(){
    	$acl = new Zend_Acl();
    	$roles = Jien::model("Role")->orderBy('role.role_id asc')->leftJoin("Role r2", "r2.role_id = role.parent_id", "r2.role as parent_role")->get()->rows();
		if($roles){
	    	foreach($roles AS $role){
	    		$acl->addRole(new Zend_Acl_Role($role['role']), $role['parent_role']);
	    	}
		}
    	$this->acl = $acl;
    }

    public function hasRole($role, $action = ''){

    	$resource = $this->params('controller');
    	if(!in_array($resource, $this->_resources)){
    		$this->acl->add(new Zend_Acl_Resource($resource));
    		$this->_resources[] = $resource;
    	}

    	if($action != ''){
    		$permission = array($action);
    	}else{
    		$permission = null;
    	}
    	$this->acl->allow($role, $resource, $permission);

    	if(!empty($this->user['role'])){
    		$user_role = $this->user['role'];
    	}else{
    		$user_role = 'guest';
    	}

    	if($action != ''){
    		if(!$this->acl->isAllowed($user_role, $resource, $action)){
				return false;
			}
    	}else{
    		if(!$this->acl->isAllowed($user_role, $resource)){
				return false;
			}
    	}

		return true;
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
        	Jien::model("User")->update($user, $condi);
        	$user['user_id'] = $data['user_id'];
        	$data = Jien::model("User")->where($condi)->joinRole()->get()->row();
        }
        $user['accessed'] = date("Y-m-d h:i:s");
        $user['role'] = $data['role'];
        $user['screenname'] = $data['screenname'];
		$this->user = $_SESSION['user'] = $user;
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
