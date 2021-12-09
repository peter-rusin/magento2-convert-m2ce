<?php
declare(strict_types=1);

namespace Convert\Blog\Command\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\DeleteCategoryByIdInterface;
use Convert\Blog\Model\CategoryModel;
use Convert\Blog\Model\CategoryModelFactory;
use Convert\Blog\Model\ResourceModel\CategoryResource;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class DeleteByIdCommand implements DeleteCategoryByIdInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var CategoryModelFactory */
    private $modelFactory;

    /** @var CategoryResource */
    private $resource;

    public function __construct(
        LoggerInterface $logger,
        CategoryModelFactory $modelFactory,
        CategoryResource $resource
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
    }

    public function execute(int $entityId): void
    {
        try {
            /** @var CategoryModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, CategoryInterface::CATEGORY_ID);

            if (!$model->getData(CategoryInterface::CATEGORY_ID)) {
                throw new NoSuchEntityException(
                    __('Could not find Category with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete Category. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete Category.'));
        }
    }
}
