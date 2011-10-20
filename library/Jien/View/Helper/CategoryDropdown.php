<?php
class Jien_View_Helper_CategoryDropdown {

	public function categoryDropdown($type, $category_id = ''){
		$categories = Jien::model("Category")->where("category.type = '{$type}'")->orderBy("category.path ASC")->getAll();
		$drop = "<option value=''></option>";
		foreach($categories['records'] AS $record){
			$c = strlen($record['path']);
			$x = '';
			for($i = 1; $i < $c; $i++){
				$x .= '&nbsp;';
			}
			$sel = '';
			if($category_id == $record['category_id']){
				$sel = 'selected';
			}
			$drop .= "<option value='{$record['category_id']}' {$sel}>{$x} {$record['category']}</option>";
		}
		return $drop;
	}

}