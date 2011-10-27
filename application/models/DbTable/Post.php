<?php

class Application_Model_DbTable_Post extends My_Model
{
    protected $_name = 'Post';
    protected $_alias = 'p';
 	protected $_soft_delete = true;

 	public function byLatest(){
 		$this->orderBy("p.created DESC");
 		return $this;
 	}

 	public function withKeyword($keyword){
 		$this->where("p.subject LIKE '%{$keyword}%' OR p.message LIKE '%{$keyword}%'");
 		return $this;
 	}

 	public function isPublished(){
 		$this->where("p.status = 'published'");
 		return $this;
 	}

}