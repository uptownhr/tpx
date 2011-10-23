<?php
class Jien_View_Helper_DropdownOptions {

	public function dropdownOptions($options, $selected = ''){
		$html = '';
		foreach($options AS $value=>$label){
			$sel = '';
			if(!$value) $value = '';
			if($value == $selected){
				$sel = 'selected';
			}
			$html .= "<option {$sel} value='{$value}'>{$label}</option>";
		}
		return $html;
	}

}