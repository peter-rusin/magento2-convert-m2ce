<?php
declare(strict_types=1);

namespace Convert\Preorder\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;

abstract class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'preorder';
}
