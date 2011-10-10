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
    
		// set default alias
		if(empty($this->_alias)) $this->_alias = $this->_name;
		$this->_primary = $this->getPrimary();
	}
	
	public function getById($id){
		
		$row = $this->find($id);
        if (!$row) {
            throw new Exception("Could not find {$this->getPrimary()}: $id");
        }else{
        	$row = $row->current();
        }
        return $row;
	}
	
	public function save($data, $where = ''){
		
		$info = $this->info();
		$primary = $this->getPrimary();
		
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
		if($where){
			return $this->update($data, "{$where}");
		}else if(!empty($data[$primary])){
			return $this->update($data, "{$primary} = {$data[$primary]}");
		}else{
			// create a new record
			$data['active'] = 1;
			$id = $this->insert($data);	
			return $id;
		}
		
	}
	
	public function update(array $data, $where){
		unset($data['created']);
		$data['updated'] = new Zend_Db_Expr('NOW()');
		return $this->masterdb->update($this->_name, $data, $where);
	}
	
	public function insert(array $data){
		$res = $this->masterdb->insert($this->_name, $data);
		$id = $this->masterdb->lastInsertId();
		return $id;
	}
	
	public function getPrimary(){
		$info = $this->info();
		return $info['primary'][1];
	}
	
	public function delete($where){
		if(is_int($where)){
			$where = $this->getPrimary() . " = " . $where;
		}
		if($this->_soft_delete === true){
			return $this->update(array(
				"deleted"	=>	new Zend_Db_Expr('NOW()'),
				"active"	=>	0,
			), $where);
		}else{
			return $this->masterdb->delete($this->_name, $where);
		}
		
	}

	protected function _resetQuery(){
		$this->_query = array();
	}
	
	protected function _getQuery(){
		$where = '';
		$select = array();
		
		$from = array($this->_alias=>$this->_name);
		
		if($this->_soft_delete){
			$this->andWhere("{$this->_alias}.active = 1");
		}
		
		if(!empty($this->_query['where']['and'])){
			$where = '('. implode(' AND ', $this->_query['where']['and']) . ')';
		}
		if(!empty($this->_query['where']['or'])){
			$where = $where . ' OR ' . implode(' OR ', $this->_query['where']['or']);
		}
		
		if(!empty($this->_query['select'])){
			foreach($this->_query['select'] AS $k=>$v){
				$fields = explode(",", $v);
				foreach($fields AS $field){
					array_push($select, trim($field));
				}
			}
		}
		
		// start query
		$q = Jien::db()->select();
		
		if(!empty($select)){
			$q = $q->from($from, $select);
		}else{
			$q = $q->from($from);
		}
		
		if(!empty($where)){
			$q = $q->where($where);
		}
		
		if(!empty($this->_query['group'])){
			$group = array();
			foreach($this->_query['group'] AS $k=>$v){
				$fields = explode(",", $v);
				foreach($fields AS $field){
					array_push($group, trim($field));
				}
			}
			$q->group($group);
		}
		
		if(!empty($this->_query['having'])){
			$having = array();
			foreach($this->_query['having'] AS $k=>$v){
				$fields = explode(",", $v);
				foreach($fields AS $field){
					array_push($having, trim($field));
				}
			}
			$q->having(implode(" AND ", $having));
		}
		
		if(!empty($this->_query['order'])){
			$order = array();
			foreach($this->_query['order'] AS $k=>$v){
				$fields = explode(",", $v);
				foreach($fields AS $field){
					array_push($order, trim($field));
				}
			}
			$q->order($order);
		}
		
		if(!empty($this->_query['limit'])){
			$q->limit($this->_query['limit']['limit'], $this->_query['limit']['skip']);
		}
		
		if(!empty($this->_query['join'])){
			foreach($this->_query['join'] AS $table=>$v){
				$join_alias = $v['alias'];
				$join_method = 'join' . ucfirst($v['type']);
				
				if(!empty($v['fields'])){
					$join_fields = array();
					$xJoinFields = explode(",", $v['fields']);
					$join_fields = array();
					foreach($xJoinFields AS $field){
						array_push($join_fields, trim($field));
					}
					$q->$join_method(array($join_alias => $table), $v['condi'], $join_fields);
				}else{
					$q->$join_method(array($join_alias => $table), $v['condi']);
				}
				
			}
		}
		
		return $q;
	}
	
	public function get($where = ''){
		if($where){
			if(is_numeric($where)){
				$this->andWhere("{$this->_alias}.{$this->getPrimary()} = {$where}");
			}
		}
		$res = $this->getAll($where);
		if(!empty($res[0])){
			return $res[0];
		}else{
			return false;
		}
	}
	
	public function enablePager($current_page = 1, $item_count_per_page = 10, $page_range = 10){
		$this->_query['pager'] = array(
			"current_page"	=>	$current_page,
			"item_count_per_page" => $item_count_per_page,
			"page_range" => $page_range,
		);
		$this->limit($item_count_per_page, ($current_page - 1) * $item_count_per_page);
		return $this;
	}
	
	public function getAll($where = ''){
		if($where){
			$this->andWhere($where);
		}
		$select = $this->_getQuery();
		
		if(!empty($this->_query['pager'])){
			$pager = Zend_Paginator::factory($select);
	        $pager->setCurrentPageNumber($this->_query['pager']['current_page']);
	        $pager->setItemCountPerPage($this->_query['pager']['item_count_per_page']);
	        $pager->setPageRange($this->_query['pager']['page_range']);
		}
		
		$stmt = Jien::db()->query($select);
		$rows = $stmt->fetchAll();
		$res = array();
		if($rows){
			$res = array(
				"records"	=>	$rows,
			);
			if(!empty($pager)){
				$res['paginator'] = $pager;
			}
			$this->_resetQuery();
		}
		return $res;
	}

	public function groupBy($group){
		$this->_query['group'][] = $group;
		return $this;
	}
	
	public function having($having){
		$this->_query['having'][] = $having;
		return $this;
	}
	
	public function select($select = ''){
		if($select) $this->_query['select'] = array($select);
		return $this;
	}
	
	public function addSelect($select){
		$this->_query['select'][] = $select;
		return $this;
	}
	
	public function where($where){
		$this->_query['where']['and'] = array('('.$where.')');
		return $this;
	}
	
	public function andWhere($where){
		$this->_query['where']['and'][] = '('.$where.')';
		return $this;
	}
	
	public function orWhere($where){
		$this->_query['where']['or'][] = '('.$where.')';
		return $this;
	}
	
	public function orderBy($order){
		$this->_query['order'][] = $order;
		return $this;
	}

	public function limit($limit, $skip = 0){
		$this->_query['limit']['limit'] = $limit;
		$this->_query['limit']['skip'] = $skip;
		return $this;
	}
	
	public function join($type, $table, $condi, $fields = ''){
		$xTable = explode(" ", $table);
		$table = $xTable[0];
		if(!empty($xTable[1])){
			$alias = $xTable[1];
		}else{
			$alias = Jien::model($table)->_alias;
		}
		$this->_query['join'][$table]['alias'] = $alias;
		$this->_query['join'][$table]['type'] = 'left';
		$this->_query['join'][$table]['condi'] = $condi;
		$this->_query['join'][$table]['fields'] = $fields;
		
		return $this;
	}
	
	public function leftJoin($table, $condi, $fields = ''){
		$this->join('left', $table, $condi, $fields);
		return $this;
	}
	
	public function innerJoin($table, $condi, $fields = ''){
		$this->join('inner', $table, $condi, $fields);
		return $this;
	}
	
	public function rightJoin($table, $condi, $fields = ''){
		$this->join('right', $table, $condi, $fields);
		return $this;
	}
	
	public function fullJoin($table, $condi, $fields = ''){
		$this->join('full', $table, $condi, $fields);
		return $this;
	}
	
	

}
?>