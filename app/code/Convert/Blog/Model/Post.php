<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Model\ResourceModel\PostResource;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements \Convert\Blog\Api\Data\PostInterface
{
    protected $_eventPrefix = 'post_model';

    protected function _construct()
    {
        $this->_init(PostResource::class);
    }

    /** @inheritDoc */
    public function getPostId(): ?int
    {
        return $this->getData(self::POST_ID) === null ? null
            : (int)$this->getData(self::POST_ID);
    }

    /** @inheritDoc */
    public function setPostId(?int $postId): void
    {
        $this->setData(self::POST_ID, $postId);
    }

    /** @inheritDoc */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /** @inheritDoc */
    public function setTitle(?string $title): void
    {
        $this->setData(self::TITLE, $title);
    }

    /** @inheritDoc */
    public function getExcerpt(): ?string
    {
        return $this->getData(self::EXCERPT);
    }

    /** @inheritDoc */
    public function setExcerpt(?string $excerpt): void
    {
        $this->setData(self::EXCERPT, $excerpt);
    }

    /** @inheritDoc */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /** @inheritDoc */
    public function setContent(?string $content): void
    {
        $this->setData(self::CONTENT, $content);
    }

    /** @inheritDoc */
    public function getCategoryId(): ?int
    {
        return $this->getData(self::CATEGORY_ID) === null ? null
            : (int)$this->getData(self::CATEGORY_ID);
    }

    /** @inheritDoc */
    public function setCategoryId(?int $categoryId): void
    {
        $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /** @inheritDoc */
    public function getUrl(): ?string
    {
        return $this->getData(self::URL);
    }
}
