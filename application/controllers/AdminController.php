<?php

class AdminController extends My_Controller {

    public function init(){
    	parent::init();

    	if(!empty($_SESSION['user'])){
    		$this->_helper->layout()->setLayout('admin');
    	}else{
    		$this->_helper->layout()->setLayout('admin-loggedout');
            $this->render('index');
    	}

        // view vars
        $this->view->title = "Jien Framework";
    }

    public function dataAction(){
    	$data = $this->params();
    	$model = $data['model'];

    	$cmd = $this->params('cmd', 'save');

    	try {

    		switch($cmd){
    			case "save":
    				$id = Jien::model($model)->save($data);
		    		$primary = Jien::model($model)->getPrimary();
		    		echo Jien::outputResultToJson(200, array($primary=>$id));
    				break;

    			case "delete":
    				$id = $this->params('id');
    				$affected = Jien::model($model)->delete($id);
		    		echo Jien::outputResultToJson(200, array("affected"=>$affected), 'deleted');
    				break;
    		}

    		exit;

    	}catch(Exception $e){

    		echo Jien::outputResultToJson(405, array(), $e->getMessage());
    		exit;

    	}
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
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("u.user_id DESC")->withPager($this->params('page', 1))->getAll();
    }

    public function userAction(){
    	$this->view->model = "User";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->render('form');
    }

    public function postsAction(){
    	$this->view->model = "Post";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("p.post_id DESC")->joinUser()->withPager($this->params('page', 1))->getAll();
    }

    public function postAction(){
    	$this->view->model = "Post";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->joinUser('u.username')->get($id);
    	}
    }

    public function pagesAction(){
    	$this->view->model = "Page";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("page.page_id DESC")->joinUser()->withPager($this->params('page', 1))->getAll();
    }

    public function pageAction(){
    	$this->view->model = "Page";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->render('form');
    }

    public function contactsAction(){
    	$this->view->model = "Contact";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("contact.contact_id DESC")->withPager($this->params('page', 1))->getAll();
    }

    public function contactAction(){
    	$this->view->model = "Contact";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->render('form');
    }

}
