<?php
declare(strict_types=1);

namespace Convert\Blog\Command\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\SaveCategoryInterface;
use Convert\Blog\Model\CategoryModel;
use Convert\Blog\Model\CategoryModelFactory;
use Convert\Blog\Model\ResourceModel\CategoryResource;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

class SaveCommand implements SaveCategoryInterface
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

    public function execute(CategoryInterface $category): int
    {
        try {
            /** @var CategoryModel $model */
            $model = $this->modelFactory->create();
            $model->addData($category->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(CategoryInterface::CATEGORY_ID)) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save Category. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save Category.'));
        }

        return (int)$model->getData(CategoryInterface::CATEGORY_ID);
    }
}
