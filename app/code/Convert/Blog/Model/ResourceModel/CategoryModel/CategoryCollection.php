<?php
declare(strict_types=1);

namespace Convert\Blog\Model\ResourceModel\CategoryModel;

use Convert\Blog\Api\Data\CategoryInterface;
use Convert\Blog\Model\CategoryModel;
use Convert\Blog\Model\ResourceModel\CategoryResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class CategoryCollection extends AbstractCollection
{
    protected $_eventPrefix = 'category_collection';

    /** @var \Magento\Framework\UrlInterface */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->urlBuilder = $urlBuilder;
    }

    /** @inheritdoc */
    protected function _construct()
    {
        $this->_init(CategoryModel::class, CategoryResource::class);
    }

    protected function _afterLoadData()
    {
        /** @var CategoryInterface $category */
        foreach($this->getItems() as $category) {
            $category->setData(
                CategoryInterface::URL,
                $this->urlBuilder->getUrl(
                    'blog/category/view',
                    ['category_id' => $category->getCategoryId()]
                )
            );
        }
    }
}
