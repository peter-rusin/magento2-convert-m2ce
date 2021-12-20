<?php
declare(strict_types=1);

namespace Convert\Blog\Ui\DataProvider;

use Convert\Blog\Api\CategoryRepositoryInterface;
use Convert\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

class CategoryDataProvider extends DataProvider
{
    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    /** @var SearchResultFactory */
    private $searchResultFactory;

    /** @var array */
    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        CategoryRepositoryInterface $categoryRepository,
        SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->categoryRepository = $categoryRepository;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->categoryRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            CategoryInterface::CATEGORY_ID
        );
    }

    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $this->loadedData = parent::getData();
        $itemsById = [];

        foreach ($this->loadedData['items'] as $item) {
            $itemsById[(int)$item[CategoryInterface::CATEGORY_ID]] = $item;
        }

        if ($id = $this->request->getParam(CategoryInterface::CATEGORY_ID)) {
            $this->loadedData['entity'] = $itemsById[(int)$id];
        }

        return $this->loadedData;
    }
}
