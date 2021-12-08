<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Api\Data;

interface PhysicalStockInterface {
    const PRODUCT_ID = 'product_id';
    const STOCKIST_STORE_ID = 'stockist_store_id';
    const QUANTITY = 'quantity';

    public function getProductId(): int;
    public function getStockistStoreId(): int;
    public function getQuantity(): int;
    public function setProductId(int $productId): PhysicalStockInterface;
    public function setStockistStoreId(int $stockistStoreId): PhysicalStockInterface;
    public function setQuantity(int $quantity): PhysicalStockInterface;
}
