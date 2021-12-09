<?php
declare(strict_types=1);

namespace Convert\Blog\Model\ResourceModel\PostModel;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Model\PostModel;
use Convert\Blog\Model\ResourceModel\PostResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class PostCollection extends AbstractCollection
{
    protected $_eventPrefix = 'post_collection';

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
        $this->_init(PostModel::class, PostResource::class);
    }

    protected function _afterLoadData()
    {
        /** @var PostInterface $post */
        foreach($this->getItems() as $post) {
            $post->setData(
                PostInterface::URL,
                $this->urlBuilder->getUrl(
                    'blog/post/view',
                    ['post_id' => $post->getPostId()]
                )
            );
        }
    }
}
