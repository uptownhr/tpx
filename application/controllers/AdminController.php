<?php

class AdminController extends My_Controller {

    public function init(){
    	parent::init();

    	if(!empty($_SESSION['user']) && $_SESSION['user']['role'] == 'Moderator'){
    		$this->layout('admin');
    	}else{
    		$this->layout('admin-loggedout');
            $this->view('index');
    	}

        // view vars
        $this->view->title = "Jien Framework";
        $this->view->data = new Jien_Model_Factory(); // model output, contains row()/rows()/pager()

    }

    // all the save/delete requests goes through here and calls on the model's save/delete accordingly
    public function dataAction(){
    	$data = $this->params();
    	$model = $data['model'];

    	$cmd = $this->params('cmd', 'save');

    	try {

    		switch($cmd){
    			case "save":
    				$id = Jien::model($model)->save($data);
		    		$primary = Jien::model($model)->getPrimary();
		    		$this->json(array($primary=>$id), 200, 'saved');
    				break;

    			case "delete":
    				$id = $this->params('id');
    				$affected = Jien::model($model)->delete($id);
    				$this->json(array("affected"=>$affected), 200, 'deleted');
    				break;
    		}

    	}catch(Exception $e){
			$this->json(array(), 405, $e->getMessage());
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
    	$this->view->data = Jien::model($this->view->model)->orderBy("u.user_id DESC")->joinProvider()->joinRole()->withPager($this->params('page', 1))->filter($this->params())->get();
    }

    public function userAction(){
    	$this->view->model = "User";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->view('form');
    }

    public function rolesAction(){
    	$this->view->model = "Role";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("role.role_id ASC")->withPager($this->params('page', 1))->filter($this->params())->get();
    }

    public function roleAction(){
    	$this->view->model = "Role";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->view('form');
    }

    public function postsAction(){
    	$this->view->model = "Post";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("p.post_id DESC")->joinCategory()->joinUser()->withPager($this->params('page', 1))->filter($this->params())->get();
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
    	$this->view->data = Jien::model($this->view->model)->orderBy("page.rank ASC")->withPager($this->params('page', 1))->filter($this->params())->get();
    }

    public function pageAction(){
    	$this->view->model = "Page";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
    }

    public function contactsAction(){
    	$this->view->model = "Contact";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)->orderBy("contact.contact_id DESC")->withPager($this->params('page', 1))->filter($this->params())->get();
    }

    public function contactAction(){
    	$this->view->model = "Contact";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
        $this->view('form');
    }

    public function categoriesAction(){
    	$this->view->model = "Category";
    	$this->view->primary = Jien::model($this->view->model)->getPrimary();
    	$this->view->data = Jien::model($this->view->model)
    		->orderBy("category.category_id DESC")
    		->filter($this->params())
    		->withPager($this->params('page', 1))
    	->get();
    }

    public function categoryAction(){
    	$this->view->model = "Category";
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model($this->view->model)->get($id);
    	}
    }

}
