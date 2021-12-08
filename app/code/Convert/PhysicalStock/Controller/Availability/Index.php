<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Controller\Availability;

use Convert\PhysicalStock\Model\ResourceModel\PhysicalStock\Collection;
use Convert\PhysicalStock\Model\ResourceModel\PhysicalStock\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Webapi\Exception;

class Index implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /** @var ResultFactory */
    private $resultFactory;

    /** @var RequestInterface */
    private $request;

    /** @var CollectionFactory */
    private $collectionFactory;

    public function __construct(
        ResultFactory     $resultFactory,
        RequestInterface  $request,
        CollectionFactory $collectionFactory
    )
    {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(): ResultInterface
    {
        $productId = (int)$this->request->getParam('product_id');
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        if (!$productId) {
            return $result
                ->setHttpResponseCode(Exception::HTTP_BAD_REQUEST)
                ->setData([
                    'errors' => [__('missing product_id query param')],
                    'items' => []
                ]);
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->filterByProductId($productId);

        $data = $collection->toArray([
            'stockist_store',
            'quantity'
        ]);

        return $this->resultFactory
            ->create(ResultFactory::TYPE_JSON)
            ->setData(array_merge(['errors' => []], $data));
    }
}
