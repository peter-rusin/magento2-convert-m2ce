<?php
declare(strict_types=1);

namespace Convert\PhysicalStock\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const PHYSICAL_STOCK_IS_ENABLED_XML_PATH = 'physical_stock/general/enabled';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(int $storeId = null) : bool
    {
        return $this->scopeConfig->isSetFlag(
            self::PHYSICAL_STOCK_IS_ENABLED_XML_PATH,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
