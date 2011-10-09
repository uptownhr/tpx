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
 	
}