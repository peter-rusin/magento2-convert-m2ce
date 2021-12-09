<?php
declare(strict_types=1);

namespace Convert\Blog\Query\Category;

use Convert\Blog\Api\Data\CategorySearchResultsInterface;
use Convert\Blog\Api\Data\CategorySearchResultsInterfaceFactory;
use Convert\Blog\Api\GetCategoryListInterface;
use Convert\Blog\Mapper\CategoryDataMapper;
use Convert\Blog\Model\ResourceModel\CategoryModel\CategoryCollection;
use Convert\Blog\Model\ResourceModel\CategoryModel\CategoryCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class GetListQuery implements GetCategoryListInterface
{
    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /** @var CategoryCollectionFactory */
    private $entityCollectionFactory;

    /** @var CategoryDataMapper */
    private $entityDataMapper;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var CategorySearchResultsInterfaceFactory */
    private $searchResultFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CategoryCollectionFactory $entityCollectionFactory,
        CategoryDataMapper $entityDataMapper,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategorySearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->entityCollectionFactory = $entityCollectionFactory;
        $this->entityDataMapper = $entityDataMapper;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): CategorySearchResultsInterface
    {
        /** @var CategoryCollection $collection */
        $collection = $this->entityCollectionFactory->create();

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }
        $entityDataObjects = $this->entityDataMapper->map($collection);

        /** @var CategorySearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($entityDataObjects);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
