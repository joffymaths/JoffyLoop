<?php
namespace JoffyLoop\ProductTrackme\Api;
interface TrackingInterface
{
    /**
     * Get Sku Tracking Details
     * @api
     * @return \JoffyLoop\ProductTrackme\Api\TrackingInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTracking();


}
