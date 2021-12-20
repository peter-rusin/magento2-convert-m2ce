<?php
declare(strict_types=1);

namespace Convert\Preorder\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const PHYSICAL_STOCK_ENABLED_XML_PATH = 'convert_preorder/general/enabled';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(int $storeId = null) : bool
    {
        return $this->scopeConfig->isSetFlag(
            self::PHYSICAL_STOCK_ENABLED_XML_PATH,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
