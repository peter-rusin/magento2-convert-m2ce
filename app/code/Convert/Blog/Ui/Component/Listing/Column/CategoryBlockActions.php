<?php
declare(strict_types=1);

namespace Convert\Blog\Ui\Component\Listing\Column;

use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class CategoryBlockActions extends Column
{
    private const ENTITY_NAME = 'Category';
    private const EDIT_URL_PATH = 'convert_blog/category/edit';
    private const DELETE_URL_PATH = 'convert_blog/category/delete';

    /** @var UrlInterface */
    private $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->urlBuilder = $urlBuilder;
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[CategoryInterface::CATEGORY_ID])) {
                    $entityName = static::ENTITY_NAME;
                    $urlData = [CategoryInterface::CATEGORY_ID => $item[CategoryInterface::CATEGORY_ID]];

                    $editUrl = $this->urlBuilder->getUrl(static::EDIT_URL_PATH, $urlData);
                    $deleteUrl = $this->urlBuilder->getUrl(static::DELETE_URL_PATH, $urlData);

                    $item[$this->getData('name')] = [
                        'edit' => $this->getActionData($editUrl, (string)__('Edit')),
                        'delete' => $this->getActionData(
                            $deleteUrl,
                            (string)__('Delete'),
                            (string)__('Delete %1', $entityName),
                            (string)__('Are you sure you want to delete a %1 record?', $entityName)
                        )
                    ];
                }
            }
        }

        return $dataSource;
    }

    private function getActionData(
        string $url,
        string $label,
        ?string $dialogTitle = null,
        ?string $dialogMessage = null
    ): array {
        $data = [
            'href' => $url,
            'label' => $label,
            'post' => true,
            '__disableTmpl' => true
        ];

        if ($dialogTitle && $dialogMessage) {
            $data['confirm'] = [
                'title' => $dialogTitle,
                'message' => $dialogMessage
            ];
        }

        return $data;
    }
}
