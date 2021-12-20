<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Category;

use Convert\Blog\Api\CategoryRepositoryInterface;
use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CategoryView extends Template
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    /** @var PostRepositoryInterface */
    private $postRepository;

    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryRepositoryInterface $categoryRepository,
        PostRepositoryInterface $postRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    private function getCategoryId() : int
    {
        return (int)$this->_request->getParam('category_id');
    }

    public function getCategory(): ?CategoryInterface
    {
        return $this->categoryRepository->getById($this->getCategoryId());
    }

    /** @return \Convert\Blog\Api\Data\PostInterface[] */
    public function getPosts(): array
    {
        $this->searchCriteriaBuilder->addFilter(
            'category_id',
            $this->getCategoryId()
        );

        return $this->postRepository->getList(
            $this->searchCriteriaBuilder->create()
        )->getItems();
    }
}
