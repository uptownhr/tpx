<?php

class BlogController extends My_Controller {

    public function init(){
        parent::init();
    }

    public function indexAction(){
    	$params = $this->params();
    	$this->view->data = Jien::model("Post")->orderBy("p.post_id DESC")->isPublished()->joinUser()->joinCategory()->filter($this->params())->withPager($this->params('page', 1))->get();
    }

    public function postAction(){
    	$id = $this->params('id');
    	if($id){
    		$this->view->data = Jien::model("Post")->joinUser('u.username')->isPublished()->get($id);
    	}
    }

    public function searchAction(){
    	$keyword = $_REQUEST['keyword'];
    	$this->view->data = Jien::model("Post")->orderBy("p.post_id DESC")->isPublished()->withKeyword($_REQUEST['keyword'])->joinUser()->withPager($this->params('page', 1))->get();

		$this->render('index');
    }

}
