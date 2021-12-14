<?php
declare(strict_types=1);

namespace Convert\Blog\Model;

use Convert\Blog\Model\ResourceModel\CategoryResource;
use Magento\Framework\Model\AbstractModel;

class Category extends AbstractModel implements \Convert\Blog\Api\Data\CategoryInterface
{
    protected $_eventPrefix = 'category_model';

    protected function _construct()
    {
        $this->_init(CategoryResource::class);
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
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /** @inheritDoc */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
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
    public function getUrl(): ?string
    {
        return $this->getData(self::URL);
    }
}
