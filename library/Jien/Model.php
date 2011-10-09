<?php

class Jien_Model extends Zend_Db_Table_Abstract {

	public function init(array $config = array()){
  	
		// parent constructor
		parent::init($config);
		
		// get default db and set it to this object
		$this->db = Zend_Registry::get('db');
		
		// set cache
		$cache = Zend_Registry::get('cache');
		Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
		
		// set masterdb resource
		$this->masterdb = Zend_Registry::get('masterdb');
    
	}
  
	/**
	 * takes an array of data and filters out any data not relevant to current table schema
	 *
	 * @param array $arr
	 * @return array
	 */
	public function filterCols($arr){
		$data = array();
		$schema = $this->info();
		foreach($arr AS $key=>$value){
			if(in_array($key, $schema['cols'])){
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	public function getById($id, $bypass_cache = false){
		
    	$info = $this->info();
		$primary = $info['primary'][1];
		$tablename = $this->_name;
		
		$id = (int)$id;
		
		$sql = 'SELECT * FROM ' . $tablename . ' WHERE ' . $primary . ' = ' . $id;
		
		if ($bypass_cache) {
			$sql .= ' AND ' . time() . ' > 0';
		}
		
        $row = $this->db->fetchRow($sql);
        if (!$row) {
            throw new Exception("Could not find $primary: $id");
        }
        return $row;
	}
	
	public function save($data){
		
		$info = $this->info();
		$primary = $info['primary'][1];
		
		// if 'id' is passed, consider this as primary key
		if(!empty($data['id'])){
			$id = $data['id'];
			unset($data['id']);
			$data[$primary] = $id;
		}
		
		// filter out any data not in table columns
		foreach($data AS $field=>$value){
			if(!in_array($field, $info['cols'])){
				unset($data[$field]);
			}
		}
		
		// if editing, just update
		if(!empty($data[$primary])){
			$cond = "$primary = $data[$primary]";
			unset($data['created']);
			$data['updated'] = Jien::getDateTime(time());
			$affected = $this->update($data, $cond);
			return $data[$primary];
		}else{
			// create a new record
			return $this->insert($data);	
		}
		
	}
	
	public function update(array $data, $where){
		return $this->masterdb->update($this->_name, $data, $where);
	}
	
	public function insert(array $data){
		$res = $this->masterdb->insert($this->_name, $data);
		$id = $this->masterdb->lastInsertId();
		return $id;
	}
	
	public function delete($where){
		return $this->masterdb->delete($this->_name, $where);
	}
	
	public function __call($method, $args) {
    	$method = substr($method,1);
    	if(!empty($args[0])){
    		$this->data[$method] = $args[0];
    	}
    	return $this;
    }

}
?>