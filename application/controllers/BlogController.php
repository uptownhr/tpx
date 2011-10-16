<?php

class BlogController extends My_Controller {

    public function init(){
        parent::init();
    }

    public function indexAction(){
    	$this->view->data = Jien::model("Post")->orderBy("p.post_id DESC")->joinUser()->withPager($this->params('page', 1))->getAll();
    }

    public function postAction(){
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model("Post")->joinUser('u.username')->get($id);
    	}
    }

    public function searchAction(){
    	$keyword = $_REQUEST['keyword'];
    	$this->view->data = Jien::model("Post")->orderBy("p.post_id DESC")->withKeyword($_REQUEST['keyword'])->joinUser()->withPager($this->params('page', 1))->getAll();

		$this->render('index');
    }

}
