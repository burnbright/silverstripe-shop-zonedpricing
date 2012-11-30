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