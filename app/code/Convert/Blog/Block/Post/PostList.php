<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Post;

use Convert\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PostList extends Template
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var PostRepositoryInterface */
    private $postRepository;

    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostRepositoryInterface $postRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->postRepository = $postRepository;
    }

    /** @return \Convert\Blog\Api\Data\PostInterface[] */
    public function getPosts() : array
    {
        return $this->postRepository->getList(
            $this->searchCriteriaBuilder->create()
        )->getItems();
    }
}
