<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Category;

use Convert\Blog\Api\CategoryRepositoryInterface;
use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Api\Data\CategoryInterfaceFactory as CategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    /** @var CategoryFactory */
    private $categoryFactory;

    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    public function execute() : ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var CategoryInterface $category */
            $category = $this->categoryFactory->create();
            $category->addData($params['general']);
            $this->categoryRepository->save($category);
            $this->messageManager->addSuccessMessage(
                __('The Category data was saved successfully')
            );
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());

            return $resultRedirect->setPath('*/*/edit', [
                CategoryInterface::CATEGORY_ID => $this->getRequest()->getParam(CategoryInterface::CATEGORY_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
