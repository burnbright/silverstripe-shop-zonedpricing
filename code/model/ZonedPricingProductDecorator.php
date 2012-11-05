<?php

class ZonedPricingProductDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'has_many' => array(
				'ZonePrices' => 'ZonePrice'
			)
		);
	}
	
	function updateCMSFields($fields){
		$fieldlist = array(
			'ZoneID' => 'Zone',
			'Price' => 'Price'
		);
		$fieldtypes = array(
			'ZoneID' => 'ZoneSelectField', //custom field required because TableField doesn't allow customising row fields
			'Price' => 'TextField'
		);
		
		$fields->addFieldToTab("Root.Content.Pricing",
			new TableField("ZonePrices", "ZonePrice",$fieldlist, $fieldtypes)	
		);
	}
	
	/**
	 * Gets zoned price
	 */
	function getZonedPrice($baseprice = null){
		$zoneprice = 0;
		$ids = Zone::get_zone_ids(); //get zone ids;
		if(is_array($ids)){
			$where = "\"ZonePrice\".\"ZoneID\" IN(".implode(",", $ids).")";
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
	
}