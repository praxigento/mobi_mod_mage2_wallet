<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Wallet\Model\Payment;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Method
    extends \Magento\Payment\Model\Method\AbstractMethod
{
    const CODE = 'praxigento_wallet';
    /** @var \Praxigento\Wallet\Service\IOperation */
    protected $callOperation;
    protected $_canCapture = true;
    protected $_canCapturePartial = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    protected $_code = self::CODE;
    protected $_isGateway = true;

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $attrValueFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Praxigento\Wallet\Service\IOperation $callOperation,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context, $registry, $extensionFactory, $attrValueFactory,
            $paymentData, $scopeConfig, $logger, $resource, $resourceCollection, $data
        );
        $this->callOperation = $callOperation;
    }

    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        parent::capture($payment, $amount);
        /* collect data */
        assert($payment instanceof \Magento\Sales\Model\Order\Payment);
        /** @var \Magento\Sales\Model\Order $order */
        $order = $payment->getOrder();
        $orderId = $order->getId();
        $customerId = $order->getCustomerId();
        /* perform payment */
        $req = new \Praxigento\Wallet\Service\Operation\Request\PayForSaleOrder();
        $req->setCustomerId($customerId);
        $req->setOrderId($orderId);
        $req->setBaseAmountToPay($amount);
        $resp = $this->callOperation->payForSaleOrder($req);
        /* TODO: add transaction ID to payment */
        $operId = $resp->getOperationId();
        $payment->setTransactionId($operId);
        return $this;
    }
}