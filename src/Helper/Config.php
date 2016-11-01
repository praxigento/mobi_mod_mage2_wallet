<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Wallet\Helper;

/**
 * Helper to get configuration parameters.
 */
class Config
{

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function getWalletActive()
    {
        $result = $this->_scopeConfig->getValue('payment/praxigento_wallet/active');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

    /**
     * @return bool
     */
    public function getWalletPartialEnabled()
    {
        $result = $this->_scopeConfig->getValue('payment/praxigento_wallet/partial_enabled');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

    /**
     * @return bool
     */
    public function getWalletPartialPercent()
    {
        $result = $this->_scopeConfig->getValue('payment/praxigento_wallet/partial_percent');
        $result *= 1;
        $result = ($result < 0) || ($result > 1) ? 0 : $result;
        return $result;
    }
}