<?php

class Jien_Controller extends Zend_Controller_Action {
	
    public function init(){
    	
    	// pass request params to view
    	$this->view->params = $this->_request->getParams();
    }

    protected function _authenticate($username, $password){
        $adapter = $this->_getAuthAdapter();
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
    
    protected function _getAuthAdapter() {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Jien::db(), "User", "username", "password", "");
        
        $select = $authAdapter->getDbSelect();
		$select->where('level > 2 AND active=1');
        
        return $authAdapter;
    }
    
    protected function params($param = '', $default = ''){
    	$request = Zend_Controller_Front::getInstance()->getRequest();
		if($param){
			return $request->getParam($param, $default);
		}else{
			return $request->getParams();
		}
    }
    
}
