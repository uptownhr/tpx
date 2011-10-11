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
    
    public function saveAction(){
    	$data = $this->params();
    	$model = $data['model'];
    	$id = Jien::model($model)->save($data);
    	echo $id;
    	exit;
    }
    
    public function deleteAction(){
    	$id = $this->params('id');
    	$model = $this->params('model');
    	$affected = Jien::model($model)->delete($id);
    	echo $affected;
    	exit;
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
    	$user_id = $this->params('id');
    	if($user_id){
    		$this->view->data = Jien::model("User")->get($user_id);
    	}
    }
    
}
