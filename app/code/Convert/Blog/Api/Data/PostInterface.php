<?php
declare(strict_types=1);

namespace Convert\Blog\Api\Data;

interface PostInterface
{
    const POST_ID = "post_id";
    const TITLE = "title";
    const EXCERPT = "excerpt";
    const CONTENT = "content";
    const CATEGORY_ID = "category_id";

    const URL = 'url';

    /**
     * Getter for PostId.
     *
     * @return int|null
     */
    public function getPostId(): ?int;

    /**
     * Setter for PostId.
     *
     * @param int|null $postId
     *
     * @return void
     */
    public function setPostId(?int $postId): void;

    /**
     * Getter for Excerpt.
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Setter for Excerpt.
     *
     * @param string|null $title
     *
     * @return void
     */
    public function setTitle(?string $title): void;

    /**
     * Getter for Excerpt.
     *
     * @return string|null
     */
    public function getExcerpt(): ?string;

    /**
     * Setter for Excerpt.
     *
     * @param string|null $excerpt
     *
     * @return void
     */
    public function setExcerpt(?string $excerpt): void;

    /**
     * Getter for Content.
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Setter for Content.
     *
     * @param string|null $content
     *
     * @return void
     */
    public function setContent(?string $content): void;

    /**
     * Getter for CategoryId.
     *
     * @return int|null
     */
    public function getCategoryId(): ?int;

    /**
     * Setter for CategoryId.
     *
     * @param int|null $categoryId
     *
     * @return void
     */
    public function setCategoryId(?int $categoryId): void;

    /**
     * Get post frontend URL
     *
     * @return string|null
     */
    public function getUrl() : ?string;
}
