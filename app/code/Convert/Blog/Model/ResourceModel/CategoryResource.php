<?php
declare(strict_types=1);

namespace Convert\Blog\Model\ResourceModel;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CategoryResource extends AbstractDb
{
    protected $_eventPrefix = 'category_resource_model';

    protected function _construct()
    {
        $this->_init('convert_blog_category', CategoryInterface::CATEGORY_ID);
        $this->_useIsObjectNew = true;
    }
}
