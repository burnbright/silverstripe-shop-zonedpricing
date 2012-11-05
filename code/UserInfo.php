<?php

/**
 * Collects and stores data about the user
 */
class UserInfo extends Object{
	
	static function set_location($address){
		if(is_array($address)){
			$address = new Address($address);
		}
		//store data in session
		Session::set("UserInfo.Location",$address);
		//$this->extend("afterSetLocation",$address);
	}
	
	static function get_location(){
		return Session::get("UserInfo.Location");
	}	
	
	static function get($field){
		return null;
	}
	
}