<?php

class Jien_Model_Factory {

	public $dataset;
	public $paginator;

	public function getData(){
		return $this->dataset;
	}

	public function setData($data){
		$this->dataset = $data;
	}

	public function getPaginator(){
		return $this->paginator;
	}

	public function setPaginator($paginator){
		$this->paginator = $paginator;
	}

}