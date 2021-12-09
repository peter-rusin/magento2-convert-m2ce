<?php
declare(strict_types=1);

namespace Convert\Blog\Model\Data;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\DataObject;

class CategoryData extends DataObject implements CategoryInterface
{
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
