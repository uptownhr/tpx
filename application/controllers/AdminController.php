<?php

class AdminController extends My_Controller {

    public function init(){
    	$this->_helper->layout()->setLayout('admin');
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
    
    
}
