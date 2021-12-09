<?php
declare(strict_types=1);

namespace Convert\Blog\Command\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\SavePostInterface;
use Convert\Blog\Model\PostModel;
use Convert\Blog\Model\PostModelFactory;
use Convert\Blog\Model\ResourceModel\PostResource;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

class SaveCommand implements SavePostInterface
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

    public function execute(PostInterface $post): int
    {
        try {
            /** @var PostModel $model */
            $model = $this->modelFactory->create();
            $model->addData($post->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(PostInterface::POST_ID)) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save Post. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save Post.'));
        }

        return (int)$model->getData(PostInterface::POST_ID);
    }
}
