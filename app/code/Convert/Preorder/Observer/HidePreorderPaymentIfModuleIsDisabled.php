<?php
declare(strict_types=1);

namespace Convert\Preorder\Observer;

use Convert\Preorder\Model\Config;
use Convert\Preorder\Model\Ui\ConfigProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ObserverInterface;
use Magento\Payment\Model\Method\Adapter;

/**
 * Hide Preorder payment method if module is disabled in the system configuration
 *
 * event name: payment_method_is_active
 */
class HidePreorderPaymentIfModuleIsDisabled implements ObserverInterface
{
    /** @var Config */
    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Adapter $paymentMethod */
        $paymentMethod = $observer->getData('method_instance');

        /** @var DataObject $result */
        $result = $observer->getData('result');

        /** @var \Magento\Quote\Api\Data\CartInterface $quote */
        $quote = $observer->getData('quote');

        if($paymentMethod->getCode() === ConfigProvider::CODE) {
            $result->setData(
                'is_available',
                $result->getData('is_available') && $this->config->isEnabled($quote->getStoreId())
            );
        }
    }
}
