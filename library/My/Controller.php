<?php

class My_Controller extends Jien_Controller {

    public function init(){
    	parent::init();

    	// set view path and layout but if it doesn't exist, it will use the default
    	$theme = 'adventure';
    	$this->view->addScriptPath(APPLICATION_PATH.'/views/'.$theme.'/');
    	$this->_helper->layout()->setLayout($theme);

    }

}
