<?php

class AdminController extends My_Controller {

    public function init(){
    	if(!empty($_SESSION['user'])){
    		$this->_helper->layout()->setLayout('admin');
    	}else{
    		$this->_helper->layout()->setLayout('admin-loggedout');
    	}
        parent::init();
    }
    
    public function preDispatch(){
        
    }
    
    public function indexAction(){
    	if(!empty($_SESSION['user'])){
    		$this->_forward('dashboard');
    	}
    }
    
    public function dashboardAction(){
    	
    }
    
    public function usersAction(){
    	$this->view->data = Jien::model("User")->enablePager($this->params('page', 1), 2)->getAll();
    }
    
    public function userAction(){
    }
    
}
