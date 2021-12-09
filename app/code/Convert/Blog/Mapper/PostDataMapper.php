<?php
declare(strict_types=1);

namespace Convert\Blog\Mapper;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\Data\PostInterfaceFactory;
use Convert\Blog\Model\PostModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of Post entities to an array of data transfer objects.
 */
class PostDataMapper
{
    /**
     * @var PostInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param PostInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        PostInterfaceFactory $entityDtoFactory
    )
    {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|PostInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var PostModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var PostInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
