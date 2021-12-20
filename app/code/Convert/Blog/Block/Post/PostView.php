<?php
declare(strict_types=1);

namespace Convert\Blog\Block\Post;

use Convert\Blog\Api\Data\PostInterface;
use Convert\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PostView extends Template
{
    /** @var PostRepositoryInterface */
    private $postRepository;

    public function __construct(
        Context $context,
        PostRepositoryInterface $postRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->postRepository = $postRepository;
    }

    private function getPostId() : int
    {
        return  (int) $this->_request->getParam('post_id');
    }

    public function getPost() : ?PostInterface
    {
        return $this->postRepository->getById($this->getPostId());
    }
}
