<?php

class ZonedRegionRestriction extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'has_one' => array(
				'Zone' => 'Zone'
			)	
		);
	}
	
}