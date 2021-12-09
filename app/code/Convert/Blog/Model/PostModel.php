<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Model\ResourceModel\PostResource;
use Magento\Framework\Model\AbstractModel;

class PostModel extends AbstractModel
{
    protected $_eventPrefix = 'post_model';

    protected function _construct()
    {
        $this->_init(PostResource::class);
    }
}
