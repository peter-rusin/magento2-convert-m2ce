<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Query\Post\GetListQuery;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PostView extends Template
{
    /** @var GetListQuery */
    private $getListQuery;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        GetListQuery $getListQuery,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->getListQuery = $getListQuery;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getPost() : ?PostInterface
    {
        $this->searchCriteriaBuilder->addFilter(
            'post_id',
            (int) $this->_request->getParam('post_id')
        );

        $searchResult = $this->getListQuery->execute(
            $this->searchCriteriaBuilder->create()
        );

        if(!$searchResult->getTotalCount()) {
            return null;
        }

        return current($searchResult->getItems());
    }
}
