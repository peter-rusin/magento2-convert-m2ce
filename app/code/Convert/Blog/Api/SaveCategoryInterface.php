<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/** @api */
interface SaveCategoryInterface
{
    /**
     * Save Category.
     * @param \Convert\Blog\Api\Data\CategoryInterface $category
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(CategoryInterface $category): int;
}
