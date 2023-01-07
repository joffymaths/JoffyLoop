<?php

namespace JoffyLoop\ProductTrackme\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TrackSkuData extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('cart_sku_tracking', 'id');
    }
}
