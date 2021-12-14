<?php
declare(strict_types=1);

namespace Convert\Preorder\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const CONVERT_PREORDER_ENABLED = 'convert_preorder/general/enabled';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(int $storeId = null) : bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CONVERT_PREORDER_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
