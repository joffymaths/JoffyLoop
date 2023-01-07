<?php
namespace JoffyLoop\ProductTrackme\Model;

use Magento\Framework\Model\AbstractModel;

class TrackSkuData extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('JoffyLoop\ProductTrackme\Model\ResourceModel\TrackSkuData');
    }
}
