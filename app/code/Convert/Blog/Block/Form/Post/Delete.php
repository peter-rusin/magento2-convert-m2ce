<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Form\Post;

use Convert\Blog\Api\Data\PostInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Delete',
            'delete',
            'deleteConfirm(\''
            . __('Are you sure you want to delete this post?')
            . '\', \'' . $this->getUrl(
                '*/*/delete',
                [PostInterface::POST_ID => $this->getPostId()]
            ) . '\')',
            [],
            20
        );
    }
}
