<?php

Object::add_extension("Zone", "ZoneDecorator");

Object::add_extension("Product", "ZonedPricingProductDecorator");
Object::add_extension("ProductVariation", "ZonedPricingProductDecorator");

Object::add_extension("Page_Controller", "LocationFormPageDecorator");
Object::add_extension("ShopUserInfo","ZoneUserInfo");

Object::add_extension("PopulateShopTask", "PopulateShopZonedPricingTask");