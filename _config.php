<?php

Object::add_extension("Product", "ZonedPricingProductDecorator");
Object::add_extension("RegionRestriction", "ZonedRegionRestriction");
Object::add_extension("Page_Controller", "LocationFormPageDecorator");
Object::add_extension("UserInfo","ZoneUserInfo");
Object::add_extension("Order","ZonePricedOrder");

Object::add_extension("PopulateShopTask", "PopulateShopZonedPricingTask");