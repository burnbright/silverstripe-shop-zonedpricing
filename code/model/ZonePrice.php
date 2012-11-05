<?php

class ZonePrice extends DataObject{
	
	static $db = array(
		'Price' => 'Currency'
	);
	
	static $has_one = array(
		'Zone' => 'Zone',
		'Product' => 'Product'
	);
	
}