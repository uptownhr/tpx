<?php

class Application_Model_DbTable_Category extends My_Model
{
    protected $_name = 'Category';
    protected $_alias = 'category';
 	protected $_soft_delete = true;
 	protected $_tree = true;

 	public function filter($str = ''){

 		// runs base filtering
 		parent::filter($str);

 		// parses string into array
		$filters = Jien::parseStrQuery($str);
		if(!empty($filters)){

			// filter by key value given
			foreach($filters AS $key=>$value){

				switch($key){

					case "type":
						$this->andWhere("category.type = '{$value}'");
					break;

				}
			}
		}
 		return $this;
 	}

 	public function save($data, $where = ''){
 		$id = parent::save($data, $where);

 		$path = '';
 		if($data['parent_id'] == 0){
 			$path = "{$id}";
 			parent::save(array(
 				"category_id"	=>	$id,
 				"path"	=>	$path,
 			));
 		}else{
 			$parent = Jien::model("Category")->select("category.path")->get($data['parent_id']);
 			$path = $parent['path'] . ',' . $id;
 			parent::save(array(
 				"category_id"	=>	$id,
 				"path"	=>	$path,
 			));
 		}
 	}


}