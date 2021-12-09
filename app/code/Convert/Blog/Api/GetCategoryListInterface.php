<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/** @api */
interface GetCategoryListInterface
{
    /**
     * Get Category list by search criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Convert\Blog\Api\Data\CategorySearchResultsInterface
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): CategorySearchResultsInterface;
}
