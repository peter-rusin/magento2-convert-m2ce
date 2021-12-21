<?php
declare(strict_types=1);

namespace Convert\Preorder\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Modal extends Template
{
    /** @var CountryCollectionFactory */
    private $countryCollectionFactory;

    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var CheckoutSession */
    private $checkoutSession;

    /** @var CustomerSession */
    private $customerSession;

    /** @var Registry */
    private $registry;

    /** @var array|null */
    private $countryOptions = null;

    public function __construct(
        Template\Context $context,
        CountryCollectionFactory $countryCollectionFactory,
        StoreManagerInterface $storeManager,
        SerializerInterface $serializer,
        CheckoutSession $checkoutSession,
        CustomerSession $customerSession,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->countryCollectionFactory = $countryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->serializer = $serializer;
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
    }

    public function getSerializedCountryOptions(): string
    {
        if (!isset($this->countryOptions)) {
            $this->countryOptions = $this->countryCollectionFactory->create()->loadByStore(
                $this->storeManager->getStore()->getId()
            )->toOptionArray();
        }

        return $this->serializer->serialize($this->countryOptions);
    }

    public function getSerializedFormDefaults() : string
    {
        try {
            $isLoggedIn = $this->customerSession->isLoggedIn();
            $customer = $this->customerSession->getCustomer();
            $address = $isLoggedIn ? $customer->getDefaultBillingAddress() : null;
            $address = $address ?? $this->checkoutSession->getQuote()->getBillingAddress();
        } catch (\Throwable $t) {
            return '{}';
        }

        $data = [
            'email' => $isLoggedIn ? $customer->getEmail() : $address->getEmail(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'street1' => $address->getStreetLine(1),
            'street2' => $address->getStreetLine(2),
            'street3' => $address->getStreetLine(3),
            'city' => $address->getCity(),
            'country' => $address->getCountryId(),
            'region' => $address->getRegion(),
            'regionId' => $address->getRegionId(),
            'postcode' => $address->getPostcode(),
            'telephone'=>  $address->getTelephone(),
            'productId' => $this->getProduct()->getId()
        ];

        return $this->serializer->serialize($data);
    }

    public function getProduct() : ?ProductInterface
    {
        return $this->registry->registry('current_product');
    }

    public function isVisible() : bool
    {
        return (bool) $this->getProduct()->getData('available_for_preorder');
    }

    protected function _toHtml()
    {
        return $this->isVisible() ? parent::_toHtml() : '';
    }
}
