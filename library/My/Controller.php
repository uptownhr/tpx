<?php

class My_Controller extends Jien_Controller {
	
    public function init(){
    	parent::init();

    	// it will first look at views/my folder for the view file but if not found, it will look for the view from the views/default folder
    	$theme = 'default';
    	$this->view->addScriptPath(APPLICATION_PATH.'/views/'.$theme.'/');

    }

}
