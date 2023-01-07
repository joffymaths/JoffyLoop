<?php
namespace JoffyLoop\ProductTrackme\Model;

use JoffyLoop\ProductTrackme\Api\TrackingInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;


class Tracking implements TrackingInterface
{

    /**
     * @var \JoffyLoop\ProductTrackme\Model\TrackSkuDataFactory
     */
    protected $trackSkuDataFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;


    public function __construct(
        \JoffyLoop\ProductTrackme\Model\TrackSkuDataFactory $trackSkuDataFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager
    )
    {
        $this->trackSkuDataFactory = $trackSkuDataFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Fetching the data form DB using rest api
     * @param void
     * @return array
     */

    public function getTracking()
    {
        // TODO: Implement getTracking() method.

        $trackingData = array();
        $trackingDataFinal = array();

        try {
            $collection = $this->trackSkuDataFactory->create()->getCollection();
            $collection->addFieldToFilter('status', 1);
            $trackingData = $collection->getData();
            if(!empty($trackingData)) {
                foreach ($trackingData as $key => $value) {
                    $trackingValue = [
                        "sku" => $value['sku'],
                        "tracking_code" => $value['tracking_code'],
                        "tracking_message" => $value['tracking_message'],
                        "created_at" => $value['created_at']
                    ];
                    $trackingDataFinal['items'][] = $trackingValue;
                }
            }
        } catch (\Exception $exception)  {
            $message = $exception->getMessage();
        }
        echo json_encode($trackingDataFinal); exit;
    }

}
