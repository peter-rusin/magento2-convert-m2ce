<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Category;

use Convert\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CategoryList extends Template
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryRepository = $categoryRepository;
    }

    /** @return \Convert\Blog\Api\Data\CategoryInterface[] */
    public function getCategories() : array
    {
        return $this->categoryRepository->getList(
            $this->searchCriteriaBuilder->create()
        )->getItems();
    }
}
