<?php
declare(strict_types=1);

namespace Convert\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @param \Convert\Blog\Api\Data\PostInterface[] $items
     *
     * @return PostSearchResultsInterface
     */
    public function setItems(array $items): PostSearchResultsInterface;

    /** @return \Convert\Blog\Api\Data\PostInterface[] */
    public function getItems(): array;
}
