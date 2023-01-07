<?php

namespace JoffyLoop\ProductTrackme\Model\ResourceModel\TrackSkuData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'JoffyLoop\ProductTrackme\Model\TrackSkuData',
            'JoffyLoop\ProductTrackme\Model\ResourceModel\TrackSkuData'
        );
    }
}
