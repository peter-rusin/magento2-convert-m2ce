<?php
declare(strict_types=1);

namespace Convert\Blog\Api\Data;

interface CategoryInterface
{
    const CATEGORY_ID = "category_id";
    const NAME = "name";
    const CONTENT = "content";

    const URL = "url";

    /** @return int|null */
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
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void;

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
     * Get post frontend URL
     *
     * @return string|null
     */
    public function getUrl() : ?string;
}
