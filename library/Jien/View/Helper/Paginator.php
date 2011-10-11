<?php
class Jien_View_Helper_Paginator {
	
	public $view;
	
	public function setView(Zend_View_Interface $view){
        $this->view = $view;
    }
	
	public function paginator($data, $text_only = false){
		if(!empty($data['paginator'])){
			if($text_only){
				return $this->view->paginationControl($data['paginator'], 'Sliding', 'partials/paginator/text.phtml');
			}else{
				return $this->view->paginationControl($data['paginator'], 'Sliding', 'partials/paginator/paginator.phtml'); 
			}
		}
	}
	
}