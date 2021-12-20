<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\Data\PostInterfaceFactory as PostFactory;
use Convert\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    /** @var PostFactory */
    private $postFactory;

    /** @var PostRepositoryInterface */
    private $postRepository;

    public function __construct(
        Context $context,
        PostFactory $postFactory,
        PostRepositoryInterface $postRepository
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
    }

    public function execute() : ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var PostInterface $post */
            $post = $this->postFactory->create();
            $post->addData($params['general']);
            $this->postRepository->save($post);

            $this->messageManager->addSuccessMessage(
                __('The Post data was saved successfully')
            );
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());

            return $resultRedirect->setPath('*/*/edit', [
                PostInterface::POST_ID => $this->getRequest()->getParam(PostInterface::POST_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
