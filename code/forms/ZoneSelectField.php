<?php

class ZoneSelectField extends DropdownField{
	
	function getSource() {
		$zones = DataObject::get("Zone");
		if($zones && $zones->exists()){
			return $zones->map('ID','Name');
		}
		return array();
	}
	
}