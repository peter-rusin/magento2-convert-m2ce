<?php
declare(strict_types=1);

namespace Convert\Blog\Controller\Adminhtml\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\Data\PostInterfaceFactory;
use Convert\Blog\Api\SavePostInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Convert_Blog::management';

    /** @var DataPersistorInterface */
    private $dataPersistor;

    /** @var SavePostInterface */
    private $saveCommand;

    /** @var PostInterfaceFactory */
    private $entityDataFactory;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        SavePostInterface $saveCommand,
        PostInterfaceFactory $entityDataFactory
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->saveCommand = $saveCommand;
        $this->entityDataFactory = $entityDataFactory;
    }

    public function execute() : ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var PostInterface|DataObject $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($params['general']);
            $this->saveCommand->execute($entityModel);
            $this->messageManager->addSuccessMessage(
                __('The Post data was saved successfully')
            );
            $this->dataPersistor->clear('entity');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->dataPersistor->set('entity', $params);

            return $resultRedirect->setPath('*/*/edit', [
                PostInterface::POST_ID => $this->getRequest()->getParam(PostInterface::POST_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
