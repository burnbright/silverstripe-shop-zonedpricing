<?php

Object::add_extension("Product", "ZonedPricingProductDecorator");
Object::add_extension("RegionRestriction", "ZonedRegionRestriction");
Object::add_extension("Page_Controller", "LocationFormPageDecorator");
Object::add_extension("UserInfo","ZoneUserInfo");