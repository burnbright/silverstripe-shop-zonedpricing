<?php

class PopulateZonesTask extends BuildTask{

	function run($request){
		if($request->getVar('clear')){
			$this->clear();
		}else{
			$this->populate();
		}
	}
	
	function populate(){
		$fixture = new YamlFixture("shop_zonedpricing/tests/fixtures/zonedpricing.yml");
		$fixture->saveIntoDatabase();
		echo "created zones, and example product.";
	}
	
	function clear(){
		DB::query("DELETE FROM \"Zone\" WHERE 1;");
		DB::query("DELETE FROM \"ZonePrice\" WHERE 1;");
		echo "Deleted all zones and zoneprices";
	}
	
}