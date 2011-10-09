<?php

class Application_Model_DbTable_User extends My_Model
{
    protected $_name = 'User';
    protected $_alias = 'u';
 	protected $_soft_delete = true;

 	public function byHuman(){
 		$this->andWhere("u.gender = 'f' OR u.gender = 'm'");
 		return $this;
 	}
 	
 	public function withPosts(){
 		$this->leftJoin("Post", "p.user_id = u.user_id", "p.subject");
 		$this->andWhere("p.user_id IS NOT NULL");
 		return $this;
 	}
 	
}