<?php

class Application_Model_DbTable_Role extends My_Model
{
    protected $_name = 'Role';
    protected $_alias = 'role';
 	protected $_soft_delete = true;
	
 	
 	public function getByName($name){
 		$this->where("role = '$name'");
 		return $this;
 	}
}