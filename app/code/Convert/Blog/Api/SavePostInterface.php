<?php
declare(strict_types=1);

namespace Convert\Blog\Api;

use Convert\Blog\Api\Data\PostInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/** @api */
interface SavePostInterface
{
    /**
     * Save Post.
     * @param \Convert\Blog\Api\Data\PostInterface $post
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(PostInterface $post): int;
}
