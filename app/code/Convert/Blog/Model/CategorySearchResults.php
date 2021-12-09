<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class CategorySearchResults extends SearchResults implements CategorySearchResultsInterface
{
    public function setItems(array $items): CategorySearchResultsInterface
    {
        return parent::setItems($items);
    }

    public function getItems(): array
    {
        return parent::getItems();
    }
}
