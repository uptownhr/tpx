<?php

class IndexController extends My_Controller {

    public function init(){
        parent::init();
    }
    
    public function indexAction(){
		$this->view->data = Jien::model("User")->enablePager($this->_getParam('page', 1), 50)->getAll();
    }
    
}
