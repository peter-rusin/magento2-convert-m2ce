<?php
declare(strict_types=1);

namespace Convert\Blog\Command\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\DeletePostByIdInterface;
use Convert\Blog\Model\PostModel;
use Convert\Blog\Model\PostModelFactory;
use Convert\Blog\Model\ResourceModel\PostResource;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class DeleteByIdCommand implements DeletePostByIdInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var PostModelFactory */
    private $modelFactory;

    /** @var PostResource */
    private $resource;

    public function __construct(
        LoggerInterface $logger,
        PostModelFactory $modelFactory,
        PostResource $resource
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
    }

    public function execute(int $entityId): void
    {
        try {
            /** @var PostModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, PostInterface::POST_ID);

            if (!$model->getData(PostInterface::POST_ID)) {
                throw new NoSuchEntityException(
                    __('Could not find Post with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete Post. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete Post.'));
        }
    }
}
