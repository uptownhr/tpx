<?php
class Jien_View_Helper_Params {
	
	public $view;
	
	public function setView(Zend_View_Interface $view){
        $this->view = $view;
    }
	
	public function params($param = '', $default = ''){
		$request = Zend_Controller_Front::getInstance()->getRequest();
		if($param){
			return $request->getParam($param, $default);
		}else{
			return $request->getParams();
		}
	}
	
}
