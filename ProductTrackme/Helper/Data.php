<?php

namespace JoffyLoop\ProductTrackme\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    protected  $curl;


    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->curl = $curl;
        $this->messageManager = $messageManager;
    }
    /**
     * using post method https://supertracking.view.agentur-loop.com/trackme and return to observer
     * @param $itemSku
     * @param $itemPrice
     * @return array
     */
    public function getAgenturLoopApi($itemSku,$itemPrice){
            try{
                header('Content-Type: application/json');
                $url = 'https://supertracking.view.agentur-loop.com/trackme';
                $data=[
                    'sku' => $itemSku,
                    'price' => $itemPrice
                ];
                $ch = curl_init($url);
                $post = json_encode($data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    $error_msg = curl_error($ch);
                }
                $responseData = json_decode($result,true);
                curl_close($ch);
                return  $responseData;
            }catch(\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong in api.'));
            }
    }
}
