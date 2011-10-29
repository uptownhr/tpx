<?php

class Jien_Model_Factory {

	protected $_data;
	protected $_pager;

	public function __construct($data = array()){
		if(!empty($data)){
			$this->setData($data);
		}
	}

	//
	// getters
	//

	// retrieve single row (can pass optional field param to get just the field)
	public function row($field = ''){
		if($field != ''){
			$row = '';
			if(!empty($this->_data[0][$field])){
				$row = $this->_data[0][$field];
			}
		}else{
			$row = $this->_data[0];
		}
		return $row;
	}

	// retrieve multiple rows
	public function rows(){
		$rows = array();
		if(!empty($this->_data)){
			$rows = $this->_data;
		}
		return $rows;
	}

	public function pager(){
		return $this->_pager;
	}


	//
	// setters
	//

	public function setData($data){
		$this->_data = $data;
	}

	public function setPager($pager){
		$this->_pager = $pager;
	}

}