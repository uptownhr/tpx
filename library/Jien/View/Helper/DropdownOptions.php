<?php
class Jien_View_Helper_DropdownOptions {

	public function dropdownOptions($options, $selected = '', $default = ''){
		$html = '';
		foreach($options AS $value=>$label){
			$sel = '';
			if(!$value) $value = '';

			if($selected != ''){
				if($value == $selected){
					$sel = 'selected';
				}
			}else{
				if($value == $default){
					$sel = 'selected';
				}
			}
			$html .= "<option {$sel} value='{$value}'>{$label}</option>";
		}
		return $html;
	}

}