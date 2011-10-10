<?php

class Jien_Controller extends Zend_Controller_Action {
	
    public function init(){
    	
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
        
        $authAdapter = new Zend_Auth_Adapter_DbTable(Jien::db());
        $authAdapter->setTableName('User')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password');
            //->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        return $authAdapter;
    }
}
