<?php

class My_Controller extends Jien_Controller {

    public function init(){
    	parent::init();

    	// if it doesn't exist, it will use the default
    	$theme = 'adventure';

    	// set path and layout file
    	$this->view->addScriptPath(APPLICATION_PATH.'/views/'.$theme.'/');
    	$this->layout($theme);

    	// set title
    	$this->view->title = "Jien - An open-source CMS built on top of Zend Framework";

    	// increase counter
    	$user_id = 0;
    	if(!empty($_SESSION['user'])){
    		$user_id = $_SESSION['user']->user_id;
    	}
    	Jien::model("Hit")->save(array(
    		"user_id"	=>	$user_id,
    		"ip"	=>	$_SERVER['REMOTE_ADDR'],
    		"page"	=>	$_SERVER['REQUEST_URI'],
    		"request_method"	=>	$_SERVER['REQUEST_METHOD'],
    	));
    }

}
