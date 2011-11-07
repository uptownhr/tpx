<?php

class My_Controller extends Jien_Controller {

    public function init(){
    	parent::init();

    	// if it doesn't exist, it will use the default
    	/*$theme = 'my';
    	$this->view->addScriptPath(APPLICATION_PATH.'/views/'.$theme.'/');
    	$this->layout($theme);*/

    	// set title
    	$this->view->title = "Tthe Panty Exchange";

    	// increase counter
    	Jien::model("Hit")->save(array(
    		"user_id"	=>	!empty($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : 0,
    		"ip"	=>	$_SERVER['REMOTE_ADDR'],
    		"page"	=>	$_SERVER['REQUEST_URI'],
    		"request_method"	=>	$_SERVER['REQUEST_METHOD'],
    	));

    }

}
