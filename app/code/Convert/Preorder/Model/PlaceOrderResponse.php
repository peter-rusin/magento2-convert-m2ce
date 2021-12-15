<?php
declare(strict_types=1);

namespace Convert\Preorder\Model;

class PlaceOrderResponse implements \Convert\Preorder\Api\PlacePreorderResponseInterface
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getOrderId()
    {
        return $this->data['order_id'] ?? null;
    }

    public function getError()
    {
        return $this->data['error'] ?? null;
    }
}
