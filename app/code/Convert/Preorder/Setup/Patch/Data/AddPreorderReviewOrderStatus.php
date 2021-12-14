<?php
declare(strict_types=1);

namespace Convert\Preorder\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\Status as StatusResource;

class AddPreorderReviewOrderStatus implements DataPatchInterface
{
    const PREORDER_REVIEW_LABEL = 'Preorder Review';
    const PREORDER_REVIEW_STATUS = 'preorder_review';

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var StatusFactory */
    private $statusFactory;

    /** @var StatusResource */
    private $statusResource;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StatusFactory $statusFactory,
        StatusResource $statusResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->statusFactory = $statusFactory;
        $this->statusResource = $statusResource;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $status = $this->statusFactory->create();
        $this->statusResource->load(
            $status,
            'preorder_review'
        );

        // create status only if it does not exist yet
        if (!$status->getStatus()) {
            /** @var \Magento\Sales\Model\Order\Status $status */
            $status->setData([
                'label' => self::PREORDER_REVIEW_LABEL,
                'status' => self::PREORDER_REVIEW_STATUS
            ]);
            $this->statusResource->save($status);
            $status->assignState(Order::STATE_NEW, false, true);
        }

        $this->moduleDataSetup->endSetup();

        return $this;
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
