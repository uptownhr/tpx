<?php

class ContactController extends My_Controller {

    public function init(){
        parent::init();
    }

    public function indexAction(){

    }

    public function addAction(){
    	try {
    		$id = Jien::model("Contact")->save($_POST);
    		$primary = Jien::model("Contact")->getPrimary();
    		$this->json(array($primary=>$id), 200, 'saved');
    	}catch(Exception $e){
    		$this->json(array(), 405, $e->getMessage());
    	}
    }
}
