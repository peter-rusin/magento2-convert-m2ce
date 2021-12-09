<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Post;

use Convert\Blog\Query\Post\GetListQuery;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PostList extends Template
{
    /** @var GetListQuery */
    private $getListQuery;

    public function __construct(
        Context $context,
        GetListQuery $getListQuery,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->getListQuery = $getListQuery;
    }

    /** @return \Convert\Blog\Api\Data\PostInterface[] */
    public function getPosts() : array
    {
        return $this->getListQuery->execute()->getItems();
    }
}
