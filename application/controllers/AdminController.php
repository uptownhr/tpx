<?php

class AdminController extends My_Controller {

    public function init(){
    	if(!empty($_SESSION['user'])){
    		$this->_helper->layout()->setLayout('admin');
    	}else{
    		$this->_helper->layout()->setLayout('admin-loggedout');
    	}
        parent::init();
        
        // view vars
        $this->view->title = "Jien Framework";
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
    	$this->view->model = "User";
    	$this->view->data = Jien::model($this->view->model)->orderBy("u.user_id DESC")->enablePager($this->params('page', 1))->getAll();
    }
    
    public function userAction(){
    	$this->view->model = "User";
    	$user_id = $this->params('id');
    	if($user_id){
    		$this->view->data = Jien::model($this->view->model)->get($user_id);
    	}
    }
    
    public function postsAction(){
    	$this->view->model = "Post";
    	$this->view->data = Jien::model($this->view->model)->withUser()->enablePager($this->params('page', 1))->getAll();
    }
    
    public function postAction(){
    	$this->view->model = "Post";
    	$user_id = $this->params('id');
    	if($user_id){
    		$this->view->data = Jien::model($this->view->model)->get($user_id);
    	}
    }
    
    public function pagesAction(){
    	$this->view->model = "Page";
    	$this->view->data = Jien::model($this->view->model)->withUser()->enablePager($this->params('page', 1))->getAll();
    }
    
    public function pageAction(){
    	$this->view->model = "Page";
    	$user_id = $this->params('id');
    	if($user_id){
    		$this->view->data = Jien::model($this->view->model)->get($user_id);
    	}
    }
    
}
