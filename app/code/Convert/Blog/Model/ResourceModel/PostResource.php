<?php
declare(strict_types=1);

namespace Convert\Blog\Model\ResourceModel;

use Convert\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PostResource extends AbstractDb
{
    const TABLE_NAME = 'convert_blog_post';

    protected $_eventPrefix = 'post_resource_model';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, PostInterface::POST_ID);
        $this->_useIsObjectNew = true;
    }
}
