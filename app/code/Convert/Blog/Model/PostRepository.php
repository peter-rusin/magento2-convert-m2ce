<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Model\PostFactory;
use Convert\Blog\Model\ResourceModel\PostResource;
use Convert\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class PostRepository implements \Convert\Blog\Api\PostRepositoryInterface
{
    /** @var PostResource */
    protected $resource;

    /** @var PostFactory */
    protected $postFactory;

    /** @var PostCollectionFactory */
    protected $postCollectionFactory;

    /** @var SearchResultsInterfaceFactory */
    protected $searchResultsFactory;

    /** @var DataObjectHelper */
    protected $dataObjectHelper;

    /** @var DataObjectProcessor */
    protected $dataObjectProcessor;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    public function __construct(
        PostResource $resource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param \Convert\Blog\Api\Data\PostInterface $post
     * @return \Convert\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        }
        return $post;
    }

    /**
     * @param int $postId
     * @return \Convert\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $postId): PostInterface
    {
        $post = $this->postFactory->create();
        $post->load($postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with the "%1" ID doesn\'t exist.', $postId));
        }
        return $post;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var \Convert\Blog\Model\ResourceModel\Post\Collection $collection */
        $collection = $this->postCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post): bool
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param int $postId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $postId): bool
    {
        return $this->delete($this->getById($postId));
    }
}
