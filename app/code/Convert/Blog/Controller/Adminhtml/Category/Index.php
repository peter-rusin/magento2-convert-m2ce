<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    public function execute() : ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Convert_Blog::categories');
        $resultPage->addBreadcrumb(__('Category'), __('Category'));
        $resultPage->addBreadcrumb(__('Manage Categories'), __('Manage Categories'));
        $resultPage->getConfig()->getTitle()->prepend(__('Categories'));

        return $resultPage;
    }
}
