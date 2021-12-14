<?php
declare(strict_types=1);

namespace Convert\Blog\Model\Options;

use Convert\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\Data\OptionSourceInterface;

class CategoryListOptions implements OptionSourceInterface
{
    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    /** @var \Magento\Framework\Api\SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function toOptionArray()
    {
        $searchResult = $this->categoryRepository->getList(
            $this->searchCriteriaBuilder->create()
        );
        $options = [];

        /** @var \Convert\Blog\Api\Data\CategoryInterface $category */
        foreach($searchResult->getItems() as $category) {
            $options[] = [
                'label' => $category->getName(),
                'value' => $category->getCategoryId()
            ];
        }

        return $options;
    }
}
