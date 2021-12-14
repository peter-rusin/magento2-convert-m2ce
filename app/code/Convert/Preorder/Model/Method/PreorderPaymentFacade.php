<?php
declare(strict_types=1);

namespace Convert\Preorder\Model\Method;

use Magento\Payment\Model\Method\Adapter;

class PreorderPaymentFacade extends Adapter
{
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        // can only be used if there is at least one product in a quote with an enabled available_for_preorder
        /** @var \Magento\Quote\Model\Quote\Item $quoteItem */
        foreach ($quote->getItems() as $quoteItem) {
            if ($quoteItem->getProduct()->getData('available_for_preorder')) {
                return parent::isAvailable($quote);
            }
        }

        return false;
    }
}
