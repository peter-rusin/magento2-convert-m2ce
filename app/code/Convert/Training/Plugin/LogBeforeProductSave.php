<?php
declare(strict_types=1);

namespace Convert\Training\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Psr\Log\LoggerInterface;

class LogBeforeProductSave
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeSave(ProductResource $subject, Product $product)
    {
        $this->logger->debug("Training plugin - Before save product {$product->getName()}");

        return null;
    }
}
