<?php

class PopulateZonesTask extends BuildTask{

	function run($request){
		$fixture = new YamlFixture("shop_zonedpricing/tests/fixtures/zonedpricing.yml");
		$fixture->saveIntoDatabase();
	}
	
}