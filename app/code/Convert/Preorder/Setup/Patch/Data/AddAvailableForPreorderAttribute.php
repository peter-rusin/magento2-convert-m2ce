<?php
declare(strict_types=1);

namespace Convert\Preorder\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddAvailableForPreorderAttribute implements DataPatchInterface
{
    const AVAILABLE_FOR_PREORDER_ATTR = 'available_for_preorder';

    /** @var ModuleDataSetupInterface $moduleDataSetup */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(Product::ENTITY, self::AVAILABLE_FOR_PREORDER_ATTR);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::AVAILABLE_FOR_PREORDER_ATTR,
            [
                'group' => 'General',
                'type' => 'int',
                'label' => 'Available For Preorder',
                'input' => 'boolean',
                'source' => Boolean::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'required' => false,
                'default' => 0
            ]
        );

        $this->moduleDataSetup->endSetup();

        return $this;
    }

    /** @inheritdoc */
    public function getAliases()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getDependencies()
    {
        return [];
    }
}
