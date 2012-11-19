<?php

class Zone extends DataObject{
	
	static $db = array(
		'Name' => 'Varchar',
		'Description' => 'Varchar'
	);
	
	static $has_many = array(
		'Regions' => 'RegionRestriction'
	);

	/*
	 * Returns a DataSet of matching zones
	*/
	static function get_zones_for_address(Address $address){
		$join = "INNER JOIN \"RegionRestriction\" ON \"Zone\".\"ID\" = \"RegionRestriction\".\"ZoneID\"";
		$where = RegionRestriction::address_filter($address);
		$sort = "\"PostalCode\" DESC, \"City\" DESC, \"State\" DESC,\"Country\" DESC"; //* comes after alpha numerics
		return DataObject::get("Zone",$where,$sort,$join);
	}
	
	/*
	 * Get ids of zones, and store in session
	 */
	static function cache_zone_ids(Address $address){
		if($zones = self::get_zones_for_address($address)){
			$ids = $zones->map('ID','ID');
			Session::set("MatchingZoneIDs",implode(",",$ids));
			return $ids;
		}
		Session::set("MatchingZoneIDs",null);
		Session::clear("MatchingZoneIDs");
		return null;
	}
	
	/**
	 * get cached ids as array
	 */
	static function get_zone_ids(){
		if($ids = Session::get("MatchingZoneIDs")){
			return explode(",",$ids);
		}
		return null;
	}
	
	function getCMSFields($params = null){
		$fields = parent::getCMSFields($params);
		$fields->fieldByName("Root")->removeByName("Regions");
		if($this->isInDB()){
			$tablefield = new TableField("Regions", "RegionRestriction", RegionRestriction::$field_labels, RegionRestriction::get_table_field_types());
			$tablefield->setCustomSourceItems($this->Regions());
			$fields->addFieldsToTab("Root.Main", array(
				$tablefield
			));
		}
		
		return $fields;
	}
	
}