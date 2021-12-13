<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Model\ResourceModel;

class PhysicalStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TABLE_NAME = 'convert_physical_stock';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'physical_stock_id');
    }
}