# Zoned Pricing Module

Allow setting product prices per zone (groups of regions).

## Installation Instructions

 * Add module to your site root folder, name it 'shop_zonedpricing'
 * Run yoursite.tld/dev/build?flush=all
 * Add the `$SetLocationForm` form to your Page.ss template
 * Set up zones
 
## Configuration

 * Visit the `Zones` admin section to create zones
 * Set zoned prices for each product - see the Content > Pricing tab for a product.
 
If you are just testing/developing, you can run the PopulateZonesTask
(visit yoursite.tld/dev/tasks/PopulateZonesTask) to generate some dummy zones, and a product with zone pricing set up.

## How it works:

 * Predefine zones, each with multiple region restrictions
 * Get user location information
 * Find and cache matching zones
 * When a product is viewed, it will display lowest price for matching zone prices
 * Zone will update as user goes through checkout, and enters their address
 	
### How zone matching works

When the users location is entered, or a default set of zones is needed, a query is constructed to match
the entered address information (country/state). This query will join `Zones` to `RegionRestrictions`, and filter
for only zones where their corresponding region restrictions match the given address details.

Closer matches are favoured, for example: an address for Auckland, New Zealand will first be matched to a zone
which specifies Auckland, rather than another zone that targets New Zealand.
  