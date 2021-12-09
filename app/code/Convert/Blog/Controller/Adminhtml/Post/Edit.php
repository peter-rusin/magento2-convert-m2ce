<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Edit extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    public function execute() : ResultInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Convert_Blog::posts');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Post'));

        return $resultPage;
    }
}
