<?php
declare(strict_types=1);

namespace Convert\Blog\Mapper;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\Data\CategoryInterfaceFactory;
use Convert\Blog\Model\CategoryModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Category entities to an array of data transfer objects.
 */
class CategoryDataMapper
{
    /**
     * @var CategoryInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param CategoryInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        CategoryInterfaceFactory $entityDtoFactory
    )
    {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|CategoryInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var CategoryModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var CategoryInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
