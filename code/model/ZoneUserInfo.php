<?php

class ZoneUserInfo extends Extension{
	
	function onAfterSetLocation($address){
		Zone::cache_zone_ids($address);
	}
	
}