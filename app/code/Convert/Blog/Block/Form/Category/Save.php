<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Form\Category;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Save',
            'save primary',
            '',
            [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            10
        );
    }
}
