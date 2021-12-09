<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/** @api */
interface DeletePostByIdInterface
{
    /**
     * Delete Post.
     * @param int $entityId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $entityId): void;
}
