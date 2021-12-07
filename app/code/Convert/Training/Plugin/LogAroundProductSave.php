<?php
declare(strict_types=1);

namespace Convert\Training\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Psr\Log\LoggerInterface;

class LogAroundProductSave
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function aroundSave(ProductResource $subject, callable $proceed, Product $product)
    {
        $this->logger->debug("Training plugin - Around save product {$product->getName()}");

        return $proceed($product);
    }
}
