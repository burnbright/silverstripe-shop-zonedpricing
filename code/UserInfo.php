<?php

/**
 * Collects and stores data about the user
 */
class UserInfo extends Object{
	
	private static $singleton = null;
	protected static function singleton(){
		if(!self::$singleton){
			self::$singleton = new UserInfo();
		}
		return self::$singleton;
	}
	
	protected function setLocation($address){
		if(is_array($address)){
			$address = new Address($address);
		}
		Session::set("UserInfo.Location",$address);
		$this->extend("onAfterSetLocation",$address);
	}
	
	static function set_location($address){
		UserInfo::singleton()->setLocation($address);
	}
	
	static function get_location(){
		return Session::get("UserInfo.Location");
	}	
	
}