<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Block;

use Convert\PhysicalStock\Model\Config;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Template;

class PhysicalStock extends Template
{
    /** @var \Magento\Framework\Registry */
    private $registry;

    public function __construct(
        \Magento\Framework\Registry $registry,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    public function getProduct() : ?ProductInterface
    {
        return $this->registry->registry('current_product');
    }
}
