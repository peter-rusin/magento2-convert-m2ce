<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Model;

use Convert\PhysicalStock\Api\Data\PhysicalStockInterface;
use Convert\PhysicalStock\Model\PhysicalStockFactory;
use Convert\PhysicalStock\Model\ResourceModel\PhysicalStock as ResourceModel;
use Convert\PhysicalStock\Model\ResourceModel\PhysicalStock\CollectionFactory as PhysicalStockCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class PhysicalStockRepository implements \Convert\PhysicalStock\Api\PhysicalStockRepositoryInterface
{
    /** @var ResourceModel */
    protected $resource;
    /** @var PhysicalStockFactory */
    protected $physicalStockFactory;
    /** @var PhysicalStockCollectionFactory */
    protected $physicalStockCollectionFactory;
    /** @var SearchResultsInterfaceFactory */
    protected $searchResultsFactory;
    /** @var DataObjectHelper */
    protected $dataObjectHelper;
    /** @var DataObjectProcessor */
    protected $dataObjectProcessor;
    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    public function __construct(
        ResourceModel $resource,
        PhysicalStockFactory $physicalStockFactory,
        PhysicalStockCollectionFactory $physicalStockCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->physicalStockFactory = $physicalStockFactory;
        $this->physicalStockCollectionFactory = $physicalStockCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param \Convert\PhysicalStock\Api\Data\PhysicalStockInterface $physicalStock
     * @return \Convert\PhysicalStock\Api\Data\PhysicalStockInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PhysicalStockInterface $physicalStock): PhysicalStockInterface
    {
        try {
            $this->resource->save($physicalStock);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the physicalStock: %1', $exception->getMessage()),
                $exception
            );
        }
        return $physicalStock;
    }

    /**
     * @param int $physicalStockId
     * @return \Convert\PhysicalStock\Api\Data\PhysicalStockInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $physicalStockId): PhysicalStockInterface
    {
        $physicalStock = $this->physicalStockFactory->create();
        $physicalStock->load($physicalStockId);
        if (!$physicalStock->getId()) {
            throw new NoSuchEntityException(__('PhysicalStock with the "%1" ID doesn\'t exist.', $physicalStockId));
        }
        return $physicalStock;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var \Convert\PhysicalStock\Model\ResourceModel\PhysicalStock\Collection $collection */
        $collection = $this->physicalStockCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param PhysicalStockInterface $physicalStock
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PhysicalStockInterface $physicalStock): bool
    {
        try {
            $this->resource->delete($physicalStock);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the physicalStock: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $physicalStockId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $physicalStockId): bool
    {
        return $this->delete($this->getById($physicalStockId));
    }
}