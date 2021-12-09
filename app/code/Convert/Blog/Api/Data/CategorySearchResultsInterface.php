<?php
declare(strict_types=1);

namespace Convert\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Set items.
     *
     * @param \Convert\Blog\Api\Data\CategoryInterface[] $items
     *
     * @return CategorySearchResultsInterface
     */
    public function setItems(array $items): CategorySearchResultsInterface;

    /**
     * Get items.
     *
     * @return \Convert\Blog\Api\Data\CategoryInterface[]
     */
    public function getItems(): array;
}
