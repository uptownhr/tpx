<?php

class Application_Model_DbTable_User extends My_Model
{
    protected $_name = 'User';
    protected $_alias = 'u';
 	protected $_soft_delete = true;

 	public function save($data){

 		// hash password with bcrypt
 		if(!empty($data['password'])){
 			$hash = new Jien_Auth_Hash(8, false);
			$data['password'] = $hash->hashPassword($data['password']);
 		}

 		$id = parent::save($data);
 		return $id;
 	}

 	public function joinRole(){
 		$this->leftJoin("Role role", "u.role_id = role.role_id", "role.role");
 		return $this;
 	}

 	public function joinProvider(){
 		$this->leftJoin("Provider provider", "u.provider_id = provider.provider_id", "provider.provider");
 		return $this;
 	}

}