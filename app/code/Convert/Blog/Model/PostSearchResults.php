<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class PostSearchResults extends SearchResults implements PostSearchResultsInterface
{
    public function setItems(array $items): PostSearchResultsInterface
    {
        return parent::setItems($items);
    }

    public function getItems(): array
    {
        return parent::getItems();
    }
}
