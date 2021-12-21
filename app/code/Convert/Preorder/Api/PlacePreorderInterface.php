<?php
declare(strict_types=1);

namespace Convert\Preorder\Api;

/** @api */
interface PlacePreorderInterface
{
    /** @return PlacePreorderResponseInterface */
    public function place();
}
