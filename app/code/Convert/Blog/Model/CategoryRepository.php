<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Model\CategoryFactory;
use Convert\Blog\Model\ResourceModel\CategoryResource;
use Convert\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class CategoryRepository implements \Convert\Blog\Api\CategoryRepositoryInterface
{
    /** @var CategoryResource */
    protected $resource;

    /** @var CategoryFactory */
    protected $categoryFactory;

    /** @var CategoryCollectionFactory */
    protected $categoryCollectionFactory;

    /** @var SearchResultsInterfaceFactory */
    protected $searchResultsFactory;

    /** @var DataObjectHelper */
    protected $dataObjectHelper;

    /** @var DataObjectProcessor */
    protected $dataObjectProcessor;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    public function __construct(
        CategoryResource $resource,
        CategoryFactory $categoryFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param \Convert\Blog\Api\Data\CategoryInterface $category
     * @return \Convert\Blog\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(CategoryInterface $category): CategoryInterface
    {
        try {
            $this->resource->save($category);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the category: %1', $exception->getMessage()),
                $exception
            );
        }
        return $category;
    }

    /**
     * @param int $categoryId
     * @return \Convert\Blog\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $categoryId): CategoryInterface
    {
        $category = $this->categoryFactory->create();
        $category->load($categoryId);
        if (!$category->getId()) {
            throw new NoSuchEntityException(__('Category with the "%1" ID doesn\'t exist.', $categoryId));
        }
        return $category;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var \Convert\Blog\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->categoryCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param CategoryInterface $category
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CategoryInterface $category): bool
    {
        try {
            $this->resource->delete($category);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the category: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $categoryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $categoryId): bool
    {
        return $this->delete($this->getById($categoryId));
    }
}
