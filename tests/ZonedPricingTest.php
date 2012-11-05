<?php

class ZonedPricingTest extends SapphireTest{
	
	static $fixture_file = array(
		'shop_zonedpricing/tests/fixtures/zonedpricing.yml',
		'shop/tests/fixtures/Addresses.yml'
	);
	
	function setUp(){
		parent::setUp();
		//get product with regioned prices
		$this->product = $this->objFromFixture("Product", "p1");
	}
	
	function testMatchingZones(){
		$this->assertZoneMatch($this->objFromFixture("Address","wnz6012"), "TransTasman");
		$this->assertZoneMatch($this->objFromFixture("Address","wnz6012"), "Local");
		$this->assertZoneMatch($this->objFromFixture("Address","sau5024"), "TransTasman");
		$this->assertZoneMatch($this->objFromFixture("Address","sau5024"), "Special");
		$this->assertZoneMatch($this->objFromFixture("Address","scn266033"), "Asia");
		$this->assertNoZoneMatch($this->objFromFixture("Address","zch1234"));
		//TODO: test match specificity, ie state matches should come before country matches, but not postcode matches
	}
	
	function assertZoneMatch($address, $zonename){
		$zones = Zone::get_zones_for_address($address);
		$this->assertNotNull($zones);
		$this->assertDOSContains(array(
			array('Name' => $zonename)
		), $zones);
	}
	
	function assertNoZoneMatch($address){
		$zones = Zone::get_zones_for_address($address);
		$this->assertNull($zones);
	}
	
	function testZonePrices(){
		$this->assertRegionPrice(0); //check default location (before location has been set)
		Zone::cache_zone_ids($this->objFromFixture("Address","anz1010"));//transtasman zone price
		$this->assertRegionPrice(80);
		Zone::cache_zone_ids($this->objFromFixture("Address","wnz6012")); //local zone (overrides transtasman)
		$this->assertRegionPrice(10);
		Zone::cache_zone_ids($this->objFromFixture("Address","sau5024")); //special zone price (overrides transtasman)
		$this->assertRegionPrice(200);
		Zone::cache_zone_ids($this->objFromFixture("Address","zch1234")); //check price for nonmatching region
		$this->assertRegionPrice(0);
	}
	
	function assertRegionPrice($price){
		$this->assertEquals($price, $this->product->getZonedPrice(),"Checking that product price or set zone is $price");
	}
	
}