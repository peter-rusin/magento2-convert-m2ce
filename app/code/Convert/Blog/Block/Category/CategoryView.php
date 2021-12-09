<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Query\Category\GetListQuery as GetCategoryListQuery;
use Convert\Blog\Query\Post\GetListQuery as GetPostListQuery;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CategoryView extends Template
{
    /** @var GetCategoryListQuery */
    private $getCategoryListQuery;

    /** @var GetPostListQuery */
    private $getPostListQuery;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        GetCategoryListQuery $getCategoryListQuery,
        GetPostListQuery $getPostListQuery,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->getCategoryListQuery = $getCategoryListQuery;
        $this->getPostListQuery = $getPostListQuery;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getCategory(): ?CategoryInterface
    {
        $this->searchCriteriaBuilder->addFilter(
            'category_id',
            (int)$this->_request->getParam('category_id')
        );

        $searchResult = $this->getCategoryListQuery->execute(
            $this->searchCriteriaBuilder->create()
        );

        if (!$searchResult->getTotalCount()) {
            return null;
        }

        return current($searchResult->getItems());
    }

    /** @return \Convert\Blog\Api\Data\PostInterface[] */
    public function getPosts(): array
    {
        $this->searchCriteriaBuilder->addFilter(
            'category_id',
            (int)$this->_request->getParam('category_id')
        );

        return $this->getPostListQuery->execute(
            $this->searchCriteriaBuilder->create()
        )->getItems();
    }
}
