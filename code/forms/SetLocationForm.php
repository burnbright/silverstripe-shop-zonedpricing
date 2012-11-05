<?php

class SetLocationForm extends Form{
	
	function __construct($controller, $name = "SetLocationForm"){
		$countries = SiteConfig::current_site_config()->getCountriesList();
		$countryfield = new DropdownField("Country",_t('Address.COUNTRY','Country'),$countries);
		$fields = new FieldSet(
			$countryfield
		);
		$actions = new FieldSet(
			new FormAction("setLocation","set")	
		);
		parent::__construct($controller, $name, $fields, $actions);
		
		//TODO: load currently set location
		
		$this->loadDataFrom(array(
			'Country' => UserInfo::get('Country')
		));
		
	}
	
	function setLocation($data,$form){
		UserInfo::set_location($data);
		Controller::curr()->redirectBack();
	}
	
}

class LocationFormPageDecorator extends Extension{
	
	static $allowed_actions = array(
		"SetLocationForm"
	);
	
	function SetLocationForm(){
		return new SetLocationForm($this->owner);
	}
	
}