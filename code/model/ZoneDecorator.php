<?php
class ZoneDecorator extends DataExtension{
	
	private static $db = array(
		'ZoneCurrencyPrefix' => 'Varchar(1)',
		'ZoneCurrencySufix' => 'Varchar(4)'
	);
	
	function updateCMSFields(FieldList $fields){
		
	}
	
}