<?php
namespace JoffyLoop\ProductTrackme\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;
/**
 * Class CheckoutCartAddProductCompleteObserver
 */
class CheckoutCartAddProductCompleteObserver implements ObserverInterface
{

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \JoffyLoop\ProductTrackme\Model\TrackSkuDataFactory
     */
    protected $trackSkuDataFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;


    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @codeCoverageIgnore
     */
    protected $helper;

    /**
     * @param \JoffyLoop\ProductTrckme\Helper\Data $helper
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        \JoffyLoop\ProductTrackme\Model\TrackSkuDataFactory $trackSkuDataFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \JoffyLoop\ProductTrackme\Helper\Data $helper
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->trackSkuDataFactory = $trackSkuDataFactory;
        $this->messageManager = $messageManager;
        $this->helper = $helper;
    }

    /**
     * when we added product into cart time pass the sku and price
     * using post method https://supertracking.view.agentur-loop.com/trackme and save all value into DB
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {

        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getDataByKey('product');

        /** @var \Magento\Quote\Model\Quote $quote */
        $quoteId = $this->_checkoutSession->getQuote()->getId();

        /** @var \Magento\Quote\Model\Quote\Item $item */
        $item = $this->_checkoutSession->getQuote()->getItemByProduct($product);

        $itemId = $item->getId();
        $itemSku = $item->getSku();
        $itemPrice = $item->getPrice();

        $agentUrlLoopData = $this->helper->getAgenturLoopApi($itemSku,$itemPrice);

        if(isset($agentUrlLoopData["message"]) && isset($agentUrlLoopData["code"])) {
            try {
                if ($quoteId != '' && $itemId != '' && $itemSku != '') {
                    $trackSkuData = $this->trackSkuDataFactory->create();
                    $tracking_code = $agentUrlLoopData["code"];
                    $tracking_message = $agentUrlLoopData["message"];
                    $status = 1;
                    $trackSkuData->setQuoteId($quoteId);
                    $trackSkuData->setQuoteItemId($itemId);
                    $trackSkuData->setSku($itemSku);
                    $trackSkuData->setTrackingCode($tracking_code);
                    $trackSkuData->setTrackingMessage($tracking_message);
                    $trackSkuData->setStatus($status);
                    $trackSkuData->setCreatedAt(date('y-m-d H:m:s'));
                    $trackSkuData->save();
                    $this->messageManager->addSuccess(__('The data has been saved.'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
        }
    }
}
