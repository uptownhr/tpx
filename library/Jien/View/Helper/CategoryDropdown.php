<?php
class Jien_View_Helper_CategoryDropdown {

	public function categoryDropdown($type, $category_id = ''){
		$categories = Jien::model("Category")->where("category.type = '{$type}'")->orderBy("category.path ASC")->getAll();
		$drop = "<option value=''></option>";
		foreach($categories->getData() AS $record){
			$c = strlen($record['path']);
			$x = str_repeat('&nbsp;', $c - 1);
			$sel = '';
			if($category_id == $record['category_id']){
				$sel = 'selected';
			}
			$drop .= "<option value='{$record['category_id']}' {$sel}>{$x} {$record['category']}</option>";
		}
		return $drop;
	}

}