<?php

class Jien_Controller extends Zend_Controller_Action {

    public function init(){

    	// pass request params to view
    	$this->view->params = Jien::sanitizeArray($this->_request->getParams());


    }

    protected function authenticate($username, $password, $level = ''){
        $adapter = $this->_getAuthAdapter($level);
        $adapter->setIdentity($username);
        $adapter->setCredential($password);

        $auth = Zend_Auth::getInstance();

        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter($level = '') {
        $authAdapter = new Jien_Auth_Adapter_DbTable(Jien::db(), "User", "username", "password", "");
        $select = $authAdapter->getDbSelect();
        if($level != ''){
        	$select->where("user_level_id >= {$level} AND active=1");
        }else{
        	$select->where('active=1');
        }
        return $authAdapter;
    }

    protected function params($param = '', $default = ''){

		$request = Zend_Controller_Front::getInstance()->getRequest();
		if($param){
			return $request->getParam($param, $default);
		}else{
			return $request->getParams();
		}

		// @todo probably just go with prepared statements, but gotta rework how params are passed in sql clauses like where()
		// using sanitized array
    	/*$request = $this->view->params;
		if($param){
			$res = '';
			if(!empty($request[$param])){
				$res = $request[$param];
			}else{
				$res = $default;
			}
			return $res;
		}else{
			return $request;
		}*/

    }

    // renders a script i.e; admin/form will render admin/form.phtml
    public function render($script){
        $this->_helper->viewRenderer($script);
    }

    // will retrieve the contents of the file (filename with extensions, i.e; admin/form.phtml)
    public function retrieve($file){
        return $this->render($file);
    }

    public function setLayout($script){
    	$this->_helper->layout()->setLayout($script);
    }

}
