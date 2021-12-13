<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Model\ResourceModel\PhysicalStock;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'physical_stock_id';
    protected $_eventPrefix = 'convert_physical_stock_collection';
    protected $_eventObject = 'convert_physical_stock';

    protected function _construct()
    {
        $this->_init(
            \Convert\PhysicalStock\Model\PhysicalStock::class,
            \Convert\PhysicalStock\Model\ResourceModel\PhysicalStock::class
        );
    }

    public function filterByProductId(int $productId)
    {
        $this->addFieldToFilter('main_table.product_id', ['eq' => $productId]);

        return $this;
    }
}
