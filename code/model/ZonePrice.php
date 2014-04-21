<?php

class ZonePrice extends DataObject{
	
	static $db = array(
		'Price' => 'Currency'
	);
	
	static $has_one = array(
		'Zone' => 'Zone',
		'Product' => 'Product',
		'ProductVariation' => 'ProductVariation'
	);
	
	static $summary_fields = array(
		'Zone.Name' => 'Zone',
		'Price' => 'Price'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName("ProductID");
		$fields->removeByName("ProductVariationID");
		return $fields;
	}
	
}