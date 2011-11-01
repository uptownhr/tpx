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

 	public function joinUserRole(){
 		$this->leftJoin("UserRole ur", "u.user_role_id = ur.user_role_id", "ur.role");
 		return $this;
 	}

}