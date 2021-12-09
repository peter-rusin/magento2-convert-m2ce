<?php
declare(strict_types=1);

namespace Convert\Blog\Query\Post;

use Convert\Blog\Api\Data\PostSearchResultsInterface;
use Convert\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use Convert\Blog\Api\GetPostListInterface;
use Convert\Blog\Mapper\PostDataMapper;
use Convert\Blog\Model\ResourceModel\PostModel\PostCollection;
use Convert\Blog\Model\ResourceModel\PostModel\PostCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class GetListQuery implements GetPostListInterface
{
    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /** @var PostCollectionFactory */
    private $entityCollectionFactory;

    /** @var PostDataMapper */
    private $entityDataMapper;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var PostSearchResultsInterfaceFactory */
    private $searchResultFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        PostCollectionFactory $entityCollectionFactory,
        PostDataMapper $entityDataMapper,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostSearchResultsInterfaceFactory $searchResultFactory
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
    public function execute(?SearchCriteriaInterface $searchCriteria = null): PostSearchResultsInterface
    {
        /** @var PostCollection $collection */
        $collection = $this->entityCollectionFactory->create();

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $entityDataObjects = $this->entityDataMapper->map($collection);

        /** @var PostSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($entityDataObjects);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
