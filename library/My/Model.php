<?php

class My_Model extends Jien_Model {

	public function init(array $config = array()){

		// parent constructor
		parent::init($config);

	}


	/*
		sql snippets
	*/

	// enables pagination
 	public function withPager($current_page = 1, $item_count_per_page = 10, $page_range = 10){
		$this->_query['pager'] = array(
			"current_page"	=>	$current_page,
			"item_count_per_page" => $item_count_per_page,
			"page_range" => $page_range,
		);
		$this->limit($item_count_per_page, ($current_page - 1) * $item_count_per_page);
		return $this;
	}

	// joins the user model
	public function joinUser($fields = ''){
		$this->leftJoin("User", "u.user_id = {$this->_alias}.user_id", $fields);
    	return $this;
    }

}