<?php

class ZoneUserInfo extends Extension{

	function onAfterSetLocation($address){
		Zone::cache_zone_ids($address);
	}

}

class ZonedPricingProductDecorator extends DataExtension{
	
	private static $has_many = array(
		'ZonePrices' => 'ZonePrice'
	);
	
	function updateCMSFields(FieldList $fields){
		
		$fields->removeByName("Price");
		//$fields->removeByName("ZonePrices");
		
		$options = $this->owner->ZonePrices();
		$gridFieldConfig = GridFieldConfig::create()->addComponents(
			//new GridFieldAddExistingAutocompleter(),
			new GridFieldToolbarHeader(),
			new GridFieldAddNewButton('toolbar-header-right'),
			new GridFieldSortableHeader(),
			new GridFieldDataColumns(),
			new GridFieldPaginator(10),
			new GridFieldEditButton(),
			new GridFieldDeleteAction(),
			new GridFieldDetailForm()
		);
		
		$itemsTable = new GridField("ZonePrices","Zone Prices",$options,$gridFieldConfig);
			
		if($this->owner instanceof SiteTree){
			if(!$this->owner->Variations()){
				$fields->addFieldToTab('Root.Pricing.ZonePrices',$itemsTable);
			}
		}else{
			$fields->push($itemsTable);
		}
	
	}
	
	/**
	 * Gets zoned price
	 */
	function getZonedPrice(){
		
		$userlocation = ShopUserInfo::singleton()->getAddress();
		
		$zones = Zone::get_zones_for_address($userlocation);
		foreach ($zones as $zone){
			$ids[] = $zone->ID;
		}
		
		$zoneprice = 0;
		//$ids = Zone::get_zone_ids(); //get zone ids;
		if(is_array($ids)){
			if($this->owner->ClassName == "ProductVariation"){
				$where = "\"ZonePrice\".\"ProductVariationID\" = {$this->owner->ID} AND \"ZonePrice\".\"ZoneID\" IN(".implode(",", $ids).")";
			}else{
				$where = "\"ZonePrice\".\"ProductID\" = {$this->owner->ID} AND \"ZonePrice\".\"ZoneID\" IN(".implode(",", $ids).")";
			}
			//case custom sorting to
			$orderby = "";
			if(count($ids) > 1){
				$orderby = "CASE \"ZonePrice\".\"ZoneID\"";
				$count = 1;
				foreach($ids as $id){
					$orderby .= " WHEN $id THEN $count ";
					$count ++;
				}
				$orderby .= "ELSE 999 END ASC,";
			}
			$orderby .= "\"ZonePrice\".\"Price\" ASC";
			if($zp = DataObject::get_one("ZonePrice", $where, true, $orderby)){
				$zoneprice = $zp->Price;
			}
			
		}
		return $zoneprice;
	}
	
	function updateSellingPrice(&$baseprice){
		$zonedprice = $this->getZonedPrice();
		if($zonedprice){
			$baseprice = $zonedprice;
		} 
	}
	
}