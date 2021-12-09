<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Model\ResourceModel\CategoryResource;
use Magento\Framework\Model\AbstractModel;

class CategoryModel extends AbstractModel
{
    protected $_eventPrefix = 'category_model';

    protected function _construct()
    {
        $this->_init(CategoryResource::class);
    }
}
