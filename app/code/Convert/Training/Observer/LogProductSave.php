<?php
declare(strict_types=1);

namespace Convert\Training\Observer;

use Psr\Log\LoggerInterface;

/**
 * event: catalog_product_save_after
 *
 * Add log entry when product is saved
 */
class LogProductSave implements \Magento\Framework\Event\ObserverInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $observer->getData('product');
        $this->logger->debug("Training event - Product {$product->getName()} has been saved");
    }
}
