<?php
declare(strict_types=1);

namespace Convert\Preorder\Service;

use Convert\Preorder\Api\PlacePreorderInterface;
use Convert\Preorder\Api\PlacePreorderResponseInterfaceFactory as ResponseFactory;
use Convert\Preorder\Model\Ui\ConfigProvider as PreorderConfigProvider;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Quote\Api\CartRepositoryInterface as QuoteRepository;
use Magento\Quote\Api\Data\AddressInterfaceFactory as AddressFactory;
use Magento\Quote\Api\ShippingMethodManagementInterface;
use Magento\Quote\Model\QuoteManagement;

class PlacePreorderService implements PlacePreorderInterface
{
    /** @var Request */
    private $request;

    /** @var CheckoutSession */
    private $checkoutSession;

    /** @var AddressFactory */
    private $addressFactory;

    /** @var QuoteRepository */
    private $quoteRepository;

    /** @var QuoteManagement */
    private $quoteManagement;

    /** @var ProductResource */
    private $productResource;

    /** @var ProductFactory */
    private $productFactory;

    /** @var ShippingMethodManagementInterface */
    private $shippingMethodManagement;

    /** @var ResponseFactory */
    private $responseFactory;

    public function __construct(
        Request $request,
        CheckoutSession $checkoutSession,
        AddressFactory $addressFactory,
        QuoteRepository $quoteRepository,
        QuoteManagement $quoteManagement,
        ProductResource $productResource,
        ProductFactory $productFactory,
        ShippingMethodManagementInterface $shippingMethodManagement,
        ResponseFactory $responseFactory
    ) {
        $this->request = $request;
        $this->checkoutSession = $checkoutSession;
        $this->addressFactory = $addressFactory;
        $this->quoteRepository = $quoteRepository;
        $this->quoteManagement = $quoteManagement;
        $this->productResource = $productResource;
        $this->productFactory = $productFactory;
        $this->shippingMethodManagement = $shippingMethodManagement;
        $this->responseFactory = $responseFactory;
    }

    /** @inheirtDoc */
    public function place()
    {
        $params = $this->request->getBodyParams();

        /** @var \Magento\Quote\Api\Data\AddressInterface $address */
        $address = $this->addressFactory->create();
        $address->setEmail($params['email']);
        $address->setFirstname($params['firstname']);
        $address->setLastname($params['lastname']);
        $address->setStreet([$params['street1'], $params['street2']]);
        $address->setCity($params['city']);
        $address->setCountryId($params['country']);
        $address->setRegion($params['region']);
        $address->setRegionId($params['regionId'] ?? 1);
        $address->setPostcode($params['postcode']);
        $address->setTelephone($params['telephone']);

        try {
            $quote = $this->checkoutSession->getQuote();
            $quote->setIsActive(true);
            $quote->setCustomerEmail($address->getEmail());

            $quote->getShippingAddress()->addData($address->getData())->setCollectShippingRates(true);
            $quote->getBillingAddress()->addData($address->getData());

            $product = $this->productFactory->create();
            $this->productResource->load($product, $params['productId']);
            $quote->removeAllItems()->addProduct($product);

            $this->quoteRepository->save($quote);

            $shippingMethods = $this->shippingMethodManagement->getList($quote->getId());
            $shippingMethod = sprintf(
                '%s_%s',
                current($shippingMethods)->getCarrierCode(),
                current($shippingMethods)->getCarrierCode()
            );
            $quote->getShippingAddress()->setShippingMethod($shippingMethod);

            $quote->setPaymentMethod(PreorderConfigProvider::CODE);
            $quote->getPayment()->addData(['method' => PreorderConfigProvider::CODE]);

            $this->quoteRepository->save($quote);
            $order = $this->quoteManagement->submit($quote);
        } catch (\Throwable $t) {
            return $this->responseFactory->create([
                'data' => ['error' => __('There was an error during preorder creation.')]
            ]);
        }

        return $this->responseFactory->create([
            'data' => ['order_id' => $order->getId()]
        ]);
    }
}
