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
    		echo Jien::outputResultToJson(200, array($primary=>$id));
    	}catch(Exception $e){
    		echo Jien::outputResultToJson(405, array(), $e->getMessage());
    	}
    	exit;
    }
}
