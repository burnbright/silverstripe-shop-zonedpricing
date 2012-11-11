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
		$fixture = new YamlFixture("shop_zonedpricing/tests/fixtures/zonedpricing.yml");
		$fixture->saveIntoDatabase();
		DB::alteration_message('Created zones, and example product', 'created');
	}
	
	function clear(){
		DB::query("DELETE FROM \"Zone\" WHERE 1;");
		DB::query("DELETE FROM \"ZonePrice\" WHERE 1;");
		echo "Deleted all zones and zoneprices";
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