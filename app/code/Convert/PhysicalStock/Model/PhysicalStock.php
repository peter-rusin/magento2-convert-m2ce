<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Model;

use Convert\PhysicalStock\Api\Data\PhysicalStockInterface;
use Limesharp\Stockists\Api\Data\StockistInterface;
use Limesharp\Stockists\Api\StockistRepositoryInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class PhysicalStock extends AbstractModel implements PhysicalStockInterface
{
    const CACHE_TAG = 'convert_physical_stock';

    /** @var string */
    protected $_cacheTag = 'convert_physical_stock';
    /** @var string */
    protected $_eventPrefix = 'convert_physical_stock';
    /** @var StockistRepositoryInterface */
    private $stockistRepository;

    public function __construct(
        StockistRepositoryInterface $stockistRepository,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->stockistRepository = $stockistRepository;
    }

    protected function _construct()
    {
        $this->_init(\Convert\PhysicalStock\Model\ResourceModel\PhysicalStock::class);
    }

    public function toArray(array $keys = [])
    {
        if(in_array('stockist_store', $keys) || empty($keys)) {
            $this->setData(
                'stockist_store',
                $this->stockistRepository->getById($this->getStockistStoreId())->toArray([
                    'stockist_id',
                    'store_id',
                    'name'
                ])
            );
        }
        return parent::toArray($keys);
    }

    public function getProductId(): int
    {
        return (int) $this->getData(self::PRODUCT_ID);
    }

    public function getStockistStoreId(): int
    {
        return (int) $this->getData(self::STOCKIST_STORE_ID);
    }

    public function getQuantity(): int
    {
        return (int) $this->getData(self::QUANTITY);
    }

    public function setProductId(int $productId): PhysicalStockInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    public function setStockistStoreId(int $stockistStoreId): PhysicalStockInterface
    {
        return $this->setData(self::STOCKIST_STORE_ID, $stockistStoreId);
    }

    public function setQuantity(int $quantity): PhysicalStockInterface
    {
        return $this->setData(self::QUANTITY, $quantity);
    }
}
