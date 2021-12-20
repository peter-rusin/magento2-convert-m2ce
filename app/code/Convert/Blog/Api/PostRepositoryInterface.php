<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface PostRepositoryInterface
{
    /**
    * @param \Convert\Blog\Api\Data\PostInterface $post
    * @return \Convert\Blog\Api\Data\PostInterface
    */
    public function save(PostInterface $post): PostInterface;

    /**
    * @param int $postId
    * @return \Convert\Blog\Api\Data\PostInterface
    */
    public function getById(int $postId): PostInterface;

    /**
    * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    * @return SearchResultsInterface
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface;

    /**
    * @param \Convert\Blog\Api\Data\PostInterface $post
    * @return bool true on success
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function delete(PostInterface $post): bool;

    /**
    * @param int $postId
    * @return bool true on success
    * @throws \Magento\Framework\Exception\NoSuchEntityException
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function deleteById(int $postId): bool;
}