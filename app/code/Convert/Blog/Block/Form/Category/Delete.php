<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Form\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Delete',
            'delete',
            'deleteConfirm(\''
            . __('Are you sure you want to delete this category?')
            . '\', \'' . $this->getUrl(
                '*/*/delete',
                [CategoryInterface::CATEGORY_ID => $this->getCategoryId()]
            ) . '\')',
            [],
            20
        );
    }
}
