<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Category;

use Convert\Blog\Query\Category\GetListQuery;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CategoryList extends Template
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

    /** @return \Convert\Blog\Api\Data\CategoryInterface[] */
    public function getCategories() : array
    {
        return $this->getListQuery->execute()->getItems();
    }
}
