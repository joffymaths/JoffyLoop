# JoffyLoop_ProductTrackme module
JoffyLoop\ProductTrackme module allows to track product sku when add to cart. And list to use rest api.

#### Observer
This module observes the following events
`etc/events.xml`
`checkout_cart_add_product_complete` event in
`JoffyLoop\ProductTrackme\Observer\CheckoutCartAddProductCompleteObserver` file.
when we added product into cart time pass the sku and price 
using post method https://supertracking.view.agentur-loop.com/trackme and save all value into DB


### Rest Api
This Rest Api 
`etc/di.xml`
`rest/V1/tracking`
`JoffyLoop\ProductTrackme\Api\TrackingInterface`
`JoffyLoop\ProductTrackme\Model`
/pub/rest/V1/tracking
Getting full data which is tracked before.
