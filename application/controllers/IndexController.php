<?php

class IndexController extends My_Controller {

    public function init(){
        parent::init();
    }
    

    public function indexAction(){
    	
    	$d = Jien::model("User")->save(array(
    		"username" => 'jae',
    	), "gender = ''");
    	
    	$current_page = $this->_getParam('page', 1);
		$this->view->data = Jien::model("User")
			->enablePager($current_page, 500)
			->getAll();

    }
    
}
