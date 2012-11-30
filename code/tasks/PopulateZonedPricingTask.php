<?php

class PopulateZonedPricingTask extends BuildTask{

	protected $title = "Populate Zoned Pricing";
	protected $description = 'Creates zones and a TestProduct with zoned prices.';
	
	function run($request = null){
		if($request && $request->getVar('clear')){
			$this->clear();
		}else{
			$this->populate();
		}
	}
	
	function populate(){
		if(!DataObject::get_one('ZonePrice')){
			$fixture = new YamlFixture("shop_zonedpricing/tests/fixtures/zonedpricing.yml");
			$fixture->saveIntoDatabase();
			DB::alteration_message('Created zones, and example product', 'created');
		}else{
			DB::alteration_message('Zone(s) already exist, none created.');
		}
	}
	
	function clear(){
		DB::query("DELETE FROM \"ZonePrice\" WHERE 1;");
		DB::alteration_message("Deleted all zoneprices");
	}
	
}

/**
 * Makes PopulateZonedPricingTask get run after PopulateShopTask is run
 */
class PopulateShopZonedPricingTask extends Extension{
	
	function afterPopulate(){
		$task = new PopulateZonedPricingTask();
		$task->run();
	}
	
}