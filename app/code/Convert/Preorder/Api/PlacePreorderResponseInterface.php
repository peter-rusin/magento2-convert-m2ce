<?php
declare(strict_types=1);

namespace Convert\Preorder\Api;

/** @api */
interface PlacePreorderResponseInterface
{
    /** @return string|null */
    public function getOrderId();

    /** @return string|null */
    public function getError();
}
