<?php

class IndexController extends My_Controller {

    public function init(){
        parent::init();
    }
    

    public function indexAction(){
    	$current_page = $this->_getParam('page', 1);
		$this->view->data = Jien::model("User")
			->enablePager($current_page, 1)
			->getAll();

    }
    
}
