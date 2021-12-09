<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/** @api */
interface GetPostListInterface
{
    /**
     * Get Post list by search criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Convert\Blog\Api\Data\PostSearchResultsInterface
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): PostSearchResultsInterface;
}
