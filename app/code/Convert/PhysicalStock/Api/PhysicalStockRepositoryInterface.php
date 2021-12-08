<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Api;

use Convert\PhysicalStock\Api\Data\PhysicalStockInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface PhysicalStockRepositoryInterface
{
    /**
    * @param \Convert\PhysicalStock\Api\Data\PhysicalStockInterface $physicalStock
    * @return \Convert\PhysicalStock\Api\Data\PhysicalStockInterface
    */
    public function save(PhysicalStockInterface $physicalStock): PhysicalStockInterface;

    /**
    * @param int $physicalStockId
    * @return \Convert\PhysicalStock\Api\Data\PhysicalStockInterface
    */
    public function getById(int $physicalStockId): PhysicalStockInterface;

    /**
    * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    * @return SearchResultsInterface
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface;

    /**
    * @param \Convert\PhysicalStock\Api\Data\PhysicalStockInterface $physicalStock
    * @return bool true on success
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function delete(PhysicalStockInterface $physicalStock): bool;

    /**
    * @param int $physicalStockId
    * @return bool true on success
    * @throws \Magento\Framework\Exception\NoSuchEntityException
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function deleteById(int $physicalStockId): bool;
}