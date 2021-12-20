<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Form\Post;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Back To Grid',
            'back',
            sprintf("location.href = '%s';", $this->getUrl('*/*/')),
            [],
            30
        );
    }
}
