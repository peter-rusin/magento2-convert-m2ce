<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface CategoryRepositoryInterface
{
    /**
    * @param \Convert\Blog\Api\Data\CategoryInterface $category
    * @return \Convert\Blog\Api\Data\CategoryInterface
    */
    public function save(CategoryInterface $category): CategoryInterface;

    /**
    * @param int $categoryId
    * @return \Convert\Blog\Api\Data\CategoryInterface
    */
    public function getById(int $categoryId): CategoryInterface;

    /**
    * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    * @return SearchResultsInterface
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface;

    /**
    * @param \Convert\Blog\Api\Data\CategoryInterface $category
    * @return bool true on success
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function delete(CategoryInterface $category): bool;

    /**
    * @param int $categoryId
    * @return bool true on success
    * @throws \Magento\Framework\Exception\NoSuchEntityException
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function deleteById(int $categoryId): bool;
}
