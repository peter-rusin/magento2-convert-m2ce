<?php
declare(strict_types=1);

namespace Convert\Blog\Model\Options;

use Convert\Blog\Query\Category\GetListQuery;
use Magento\Framework\Data\OptionSourceInterface;

class CategoryListOptions implements OptionSourceInterface
{
    /** @var GetListQuery */
    private $getListQuery;

    public function __construct(GetListQuery $getListQuery)
    {
        $this->getListQuery = $getListQuery;
    }

    public function toOptionArray()
    {
        $searchResult = $this->getListQuery->execute();
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
