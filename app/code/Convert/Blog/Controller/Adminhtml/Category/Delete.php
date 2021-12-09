<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\DeleteCategoryByIdInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    /** @var DeleteCategoryByIdInterface */
    private $deleteByIdCommand;

    public function __construct(
        Context $context,
        DeleteCategoryByIdInterface $deleteByIdCommand
    ) {
        parent::__construct($context);
        $this->deleteByIdCommand = $deleteByIdCommand;
    }

    public function execute() : ResultInterface
    {
        /** @var ResultInterface $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
        $entityId = (int)$this->getRequest()->getParam(CategoryInterface::CATEGORY_ID);

        try {
            $this->deleteByIdCommand->execute($entityId);
            $this->messageManager->addSuccessMessage(__('You have successfully deleted Category entity'));
        } catch (CouldNotDeleteException|NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect;
    }
}
