<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Form\Category;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /** @var Context */
    private $context;

    /** @var UrlInterface */
    private $urlBuilder;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
        $this->urlBuilder = $context->getUrlBuilder();
    }

    public function getCategoryId(): int
    {
        return (int)$this->context->getRequest()->getParam(CategoryInterface::CATEGORY_ID);
    }

    protected function wrapButtonSettings(
        string $label,
        string $class,
        string $onclick = '',
        array $dataAttribute = [],
        int $sortOrder = 0
    ): array {
        return [
            'label' => $label,
            'on_click' => $onclick,
            'data_attribute' => $dataAttribute,
            'class' => $class,
            'sort_order' => $sortOrder
        ];
    }

    protected function getUrl(string $route, array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
